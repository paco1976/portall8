<?php

namespace App\Http\Controllers;

use App\Events\ClientRegistered;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Chatbot;
use App\Models\User;

include app_path('WhatsAppBot/surveyMessages.php');

class SurveyController extends Controller
{

    /** 
     * Webhook para conectar con la API de WhatsApp
     * */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function handleWebhook(Request $request)
    {
        // Verificación del token
        $token = config('app.WA_WEBHOOK_TOKEN');
        $hubChallenge = $request->input('hub_challenge');
        $hubVerifyToken = $request->input('hub_verify_token');
        if ($token === $hubVerifyToken) {
            echo $hubChallenge;
            exit;
        }
    }

    /** 
     * Guarda datos del cliente desde el formulario en el perfil del profesional
     * */
    public function save_client_info(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'publicacion_id' => 'required',
            'client_name' => 'required',
            'client_cellphone' => 'required',
            'terms' => 'accepted',
        ]);

        $survey = new Survey;
        $survey->user_id = $data['user_id'];
        $survey->publicacion_id = $data['publicacion_id'];
        $survey->client_name = $data['client_name'];
        $survey->client_cellphone = $data['client_cellphone'];

        // Si el checkbox de "agree" está clickeado, se guarda la información. Si no, no guarda la información.
        if ($request->has('agree')) {
            $survey->save();

            info('1. Nuevo cliente registrado:');
            info($data['client_name']);
            event(new ClientRegistered($survey->id, $data['user_id']));
        }

        // Retorna la vista con la información de contacto
        return redirect()->route('homeprofesional', ['id' => $data['publicacion_id'], 'info' => true]);
    }

    public function sendWhatsAppMessage($survey, $type, $message, $step, $idReceived, $messageReceived, $action, $client_phone)
    {
        info('6. Entra a sendWhatsAppMessage.');
        $recipient_phone = '';
        if ($survey) {
            $recipient_phone = $survey->client_cellphone;
        } else {
            $recipient_phone = Chatbot::where('phone', $client_phone)->first()->phone;
        }

        // API configuration
        $token = config('app.WHATSAPP_TOKEN');

        $phoneID = config('app.PHONE_ID');

        info('phone id');
        info($phoneID);
        // Api url
        $url = 'https://graph.facebook.com/v17.0/' . $phoneID . '/messages';

        $surveyMessage = null;

        // Según qué tipo de respuesta (lista, botones, texto) se quiere crea un mensaje
        if ($type === 'buttons') {
            $surveyMessage = json_encode([
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $recipient_phone,
                "type" => "interactive",
                "interactive" => [
                    "type" => "button",
                    "body" => [
                        "text" => $message
                    ],
                    "action" => json_encode($action)
                ]
            ]);
        } else if ($type === 'list') {
            $surveyMessage = json_encode([
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $recipient_phone,
                "type" => "interactive",
                "interactive" => [
                    "type" => "list",
                    "body" => [
                        "text" => $message
                    ],
                    "footer" => [
                        "text" => "Seleccioná una opción"
                    ],
                    "action" => json_encode($action)
                ]
            ]);
        } else if ($type === 'text') {
            $surveyMessage = json_encode([
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $recipient_phone,
                "type" => "text",
                "text" => [
                    "body" => $message,
                    "preview_url" => true
                ]
            ]);
        } else if ($type === 'template') {
            $surveyMessage = json_encode([
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $recipient_phone,
                "type" => "template",
                "template" => $message

            ]);
        }

        // Si el mensaje fue creado, continua con el envío del mensaje
        if ($surveyMessage) {
            $sendMessage = true;

            // Para evitar envíos repetidos
            if ($idReceived) {
                $count = Chatbot::where('message_received', $idReceived)->count();

                if ($count > 0) {
                    $sendMessage = false;
                    return;
                }
            }

            if ($sendMessage) {
                // file_put_contents("text.txt", json_encode($surveyMessage));
                info('7. Entra al if para mandar el mensaje:');
                info($surveyMessage);


                // Inicio de header y curl para envío del mensaje a la api
                $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $surveyMessage);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                // Respuesta que envía la api al enviar el mensaje
                $response = json_decode(curl_exec($curl), true);
                $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                // Fin del curl
                curl_close($curl);

                info('8. Recibe la respuesta de la api:');
                info("status code: $status_code");
                info($response);


                if ($status_code == 200 && isset($response)) {
                    $wa_id = $response['contacts'][0]['wa_id'];

                    $message_id = $response['messages'][0]['id'];

                    $messageSent = $message;

                    // Si recibió el survey
                    if ($survey) {
                        info('9. Envió la encuenta:');
                        info($survey);
                        // En el step 1 quiero cambiar el campo contacted a true y reemplazar lo que se almacena como mensaje guardado.
                        if ($step === 1) {
                            $messageSent = 'Inicio encuesta';

                            $survey->contacted = true;
                            $survey->save();
                        }
                        // Guardo los datos en la tabla Chatbot
                        Chatbot::create([
                            'survey_id' => $survey->id,
                            'message_received' => $idReceived,
                            'message_sent' => $messageSent,
                            'id_wa' => $message_id,
                            'phone' => $wa_id,
                        ]);
                    } else {
                        // Para mensajes que no está asociados con un survey, los guardo igual.
                        Chatbot::create([
                            'survey_id' => 0,
                            'message_received' => $messageReceived,
                            'message_sent' => $messageSent,
                            'id_wa' => $message_id,
                            'phone' => $wa_id,
                        ]);
                    }
                }
            }
        }
    }

    public function handleResponse(Request $request)
    {
        global $surveyMessages;

        $response = $request->all();
        info($response);
        // Chequea si la respuesta tiene status (lo que quiere decir que no es un mensaje) y sale de la función si lo tiene.
        // Si se quiere verificar lectura o recepcion va por acá
        if (isset($response['entry'][0]['changes'][0]['value']['statuses'][0])) {
            return;
        }

        // Busca tipo de mensaje (interactive o text)
        $replyType = $response['entry'][0]['changes'][0]['value']['messages'][0]['type'];
        info('Reply type');
        info($replyType);
        // Inicializa variable del mensaje recibido
        $message = false;

        // Obtiene el número del cliente
        $client_phone = $response['entry'][0]['changes'][0]['value']['messages'][0]['from'];

        // Inicializa el survey
        $survey = false;
        $chat = Chatbot::where('phone', $client_phone)
            ->where('message_sent', 'Inicio encuesta') // TODO
            ->latest()->first();
        $survey = $chat->survey;
        if ($replyType === "interactive") {
            // Chequea qué tipo de mensaje interactivo es y obtiene el mensaje
            $type = $response['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['type'];
            info('10. Entro al IF de chequeo de mensaje interactivo');
            if ($type === "button_reply") {
                $message = $response['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'];
            } else if ($type === "list_reply") {
                $message = $response['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['list_reply']['id'];
            }
        } else if ($replyType === "text") {
            $message = $response['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        } else if ($replyType === "button") {
            $message = $response['entry'][0]['changes'][0]['value']['messages'][0]['button']['payload'];
        }

        // Id del mensaje recibido
        $message_ID = $response['entry'][0]['changes'][0]['value']['messages'][0]['id'];

        // Si hay un mensaje continúa
        if ($message != null) {
            /**
             * Respuesta a init NO - manda FIN2
             */
            info('11. Recbió mensje');
            info($message);
            if ($message === 'dontSendSurvey') {
                $response = $surveyMessages['finalMessage2_text'];

                // Guarda la negativa de contestar la encuesta
                if ($survey) {
                    $survey->accepts_survey = false;
                    $survey->save();
                }

                // Envía mensaje de agradecimiento
                $this->sendWhatsAppMessage($survey, "text", $response, 2, $message_ID,  $message, '', $client_phone);
            }
            /**
             * Respuesta a init SI - manda 1a (concretó?)
             */
            else if ($message === "message1a") {

                $response = $surveyMessages['message1a_text'];

                $dataToSend = $surveyMessages['message1a_buttons'];

                // Guarda en la tabla de survey que el cliente aceptó contestar la encuesta
                if ($survey) {
                    $survey->accepts_survey = true;
                    $survey->save();
                }

                $this->sendWhatsAppMessage($survey, "buttons", $response, 2, $message_ID, $message, $dataToSend, $client_phone);
            }
            /**
             * Recibe 'no concretó' -> manda por qué no?
             */
            else if ($message === "message2a") {
                $response = $surveyMessages['message2a_text'];

                $dataToSend = $surveyMessages['message2a_buttons'];

                if ($survey) {
                    // Guarda en la tabla de survey que no se concretó un acuerdo de trabajo 
                    $survey->service_provided = false;
                    $survey->save();
                }

                $this->sendWhatsAppMessage($survey, "list", $response, 3, $message_ID, $message, $dataToSend, $client_phone);
            }
            /**
             * Recibe 'concretó' -> manda calificar
             */
            else if ($message === 'message1b') {
                if ($survey) {
                    $user = $survey->user()->first();
                    $profileName = $user->name . ' ' . $user->last_name;

                    $response = str_replace(':profileName', $profileName, $surveyMessages['message1b_text']);

                    $dataToSend = $surveyMessages['message1b_buttons'];

                    // Guarda en la tabla de survey que se concretó un acuerdo de trabajo 
                    $survey->service_provided = true;
                    $survey->save();
                }

                $this->sendWhatsAppMessage($survey, "list", $response, 3, $message_ID, $message, $dataToSend, $client_phone);
            }
            /**
             * Recibe respuestas de por qué no concretó -- manda FIN2            * 
             */
            else if (strpos($message, 'noAgree:') !== false) {
                // Guarda la palabra en el tabla de survey
                $firstWord = true;

                if ($survey) {

                    $word = substr($message, strpos($message, "noAgree:") + strlen("noAgree:"));

                    $noAgreement = $survey->no_agreement;

                    if ($noAgreement === null) {
                        $noAgreement = [];
                    } else {
                        $firstWord = false;
                    }

                    $noAgreement[] = $word;

                    $survey->no_agreement = $noAgreement;

                    $survey->save();
                }
                if ($firstWord) {
                    $response = $surveyMessages['finalMessage2_text'];
                    // Envía mensaje de agradecimiento
                    $this->sendWhatsAppMessage($survey, "text", $response, 4, $message_ID, $message, '', $client_phone);
                }
            }
            /**
             * Recibe calificación -- responde según calificación (3 opciones)
             */
            else if (strpos($message, 'rating') !== false) {

                // Obtiene el rating
                $rating = substr($message, -1);
                // Lo guarda en la tabla
                if ($survey) {
                    $survey->satisfaction = $rating;
                    $survey->save();
                }

                /**
                 * Opción a: rating 5 y 4 -> manda message1c (describir)
                 */
                if ($rating >= 4) {

                    $response = $surveyMessages['message1c_text'];

                    $dataToSend = $surveyMessages['message1c_buttons'];

                    $this->sendWhatsAppMessage($survey, "list", $response, 4, $message_ID, $message, $dataToSend, $client_phone);
                }
                /**
                 * Opción b: rating 3 -> manda message1d (pregunta)
                 */
                else if ($rating == 3) {
                    $response = $surveyMessages['message1d_text'];
                    $this->sendWhatsAppMessage($survey, "text", $response, 4, $message_ID, $message, '', $client_phone);
                }
                /**
                 * Opción c: rating 1 o 2 -> manda message1e (pregunta)
                 */
                else if ($rating < 3) {
                    $response = $surveyMessages['message1e_text'];
                    $this->sendWhatsAppMessage($survey, "text", $response, 4, $message_ID, $message, '', $client_phone);
                }
            }
            /**
             * Recibe palabra positiva --- manda FIN
             */
            else if (strpos($message, 'word:') !== false) {

                $firstWord = true;
                // Guarda la palabra en el tabla de survey
                if ($survey) {

                    $word = substr($message, strpos($message, "word:") + strlen("word:"));

                    $descriptiveWords = $survey->descriptive_words;

                    if ($descriptiveWords === null) {
                        $descriptiveWords = [];
                    } else {
                        $firstWord = false;
                    }

                    $descriptiveWords[] = $word;

                    $survey->descriptive_words = $descriptiveWords;

                    $survey->save();
                }

                if ($firstWord) {
                    $response = $surveyMessages['message1f_text'];
                    $dataToSend = $surveyMessages['message1f_buttons'];
                    $this->sendWhatsAppMessage($survey, "buttons", $response, 5, $message_ID, $message, $dataToSend, $client_phone);
                }
            } else if ($message === 'no_review') {
                $response = $surveyMessages['finalMessage1_text'];
                $this->sendWhatsAppMessage($survey, "text", $response, 5, $message_ID, $message, '', $client_phone);
            } else if ($message === 'review') {
                $response = $surveyMessages['message1g_text'];
                $this->sendWhatsAppMessage($survey, "text", $response, 5, $message_ID, $message, '', $client_phone);
            }
            /**
             * Recibe texto -- Manda mensaje final o soy robot
             */
            else {
                if ($survey) {

                    // Chequear si no se calificó 
                    if ($survey->isRatingEmpty()) {

                        // Mandar mensaje soy robot
                        $response = $surveyMessages['aRobot'];
                        $this->sendWhatsAppMessage($survey, "text", $response, 5, $message_ID, $message, '', $client_phone);
                    } else {
                        //Si se calificó, chequear si no se completó encuesta
                        if ($survey->isReviewEmpty()) {
                            // Almacenar texto enviado como review
                            $survey->review = $message;
                            $survey->save();

                            $response = $surveyMessages['finalMessage1_text'];
                            $this->sendWhatsAppMessage($survey, "text", $response, 5, $message_ID, $message, '', $client_phone);
                        } else {
                            // La encuesta ya se completó. Mandar soy un robot
                            $response = $surveyMessages['aRobot'];
                            $this->sendWhatsAppMessage($survey, "text", $response, 5, $message_ID, $message, '', $client_phone);
                        }
                    }
                } else {
                    $response = $surveyMessages['aRobot'];
                    $this->sendWhatsAppMessage($survey, "text", $response, 5, $message_ID, $message, '', $client_phone);
                }
            }
        }
    }

    // TODO: reemplazar mensaje por envío de template
    /**
     * Inicio de la encuesta por whatsapp
     */
    public function initSurvey($surveyId, $id)
    {
        global $surveyMessages;

        info('5. Entra al controller initSurvey.');
        // Busca el nombre del profesional
        $user = User::find($id);

        $survey = Survey::find($surveyId);

        $client_phone = $survey->client_cellphone;

        if ($user && $client_phone) {

            $profileName = $user->name . ' ' . $user->last_name;

            // Mensaje inicial
            // $initialMessage = str_replace(':profileName', $profileName, $surveyMessages['initialMessage_text']);;

            // $dataToSend = $surveyMessages['initialMessage_buttons'];

            $template = [
                "name" => "encuesta",
                "language" => [
                    "code" => "es_AR"
                ],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => $profileName
                            ]
                        ]
                    ],
                    [
                        "type" => "button",
                        "sub_type" => "quick_reply",
                        "index" => "0",
                        "parameters" => [
                            [
                                "type" => "payload",
                                "payload" => "message1a"
                            ]
                        ]
                    ],
                    [
                        "type" => "button",
                        "sub_type" => "quick_reply",
                        "index" => "1",
                        "parameters" => [
                            [
                                "type" => "payload",
                                "payload" => "dontSendSurvey"
                            ]
                        ]
                    ]
                ]
            ];

            $this->sendWhatsAppMessage($survey, "template", $template, 1, "", "", "", $client_phone);
        }
    }

    public function test_survey()
    {
        $surveys = Survey::latest()->take(3)->get();

        return view('admin.testSurvey', compact('surveys'));
    } 

    public function initSurveyManually(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $surveyId = $request->input('survey_id');

        $surveyController = new SurveyController();
        $surveyController->initSurvey($surveyId, $user->id);

        return back();
    }
};

