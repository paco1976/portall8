<?php

namespace App\Http\Controllers;

use App\Events\ClientRegistered;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Chatbot;
use App\Models\User;

include app_path('WhatsAppBot/surveyMessages.php');
// TODO
/** DELETE survey */
/** GET surveys */

class SurveyController extends Controller
{
    /** 
     * Webhook para conectar con la API de WhatsApp
     * */
    public function handleWebhook(Request $request)
    {
        // Verificación del token
        $token = env('WA_WEBHOOK_TOKEN');
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
        $survey->client_name = $data['client_name'];
        $survey->client_cellphone = $data['client_cellphone'];

        // Si el checkbox de "agree" está clickeado, se guarda la información. Si no, no guarda la información.
        if ($request->has('agree')) {
            $survey->save();

            //TODO: mandar survey después de cierta cantidad de tiempo
            event(new ClientRegistered($survey->id, $data['user_id']));
        }

        // Retorna la vista con la información de contacto
        return redirect()->route('homeprofesional', ['id' => $data['publicacion_id'], 'info' => true]);
    }

    public function sendWhatsAppMessage($survey, $type, $message, $step, $idReceived, $messageReceived, $timestamp, $action, $client_phone)
    {
        $recipient_phone = '';
        if ($survey) {
            $recipient_phone = $survey->client_cellphone;
        } else {
            $recipient_phone = Chatbot::where('phone_id', $client_phone)->first()->phone;
        }

        // API configuration
        // TODO: get permanent token
        $token = env('WHATSAPP_TOKEN');

        // ID de nuestro teléfono. TODO: cambiarlo al hacer el cambio de número
        $phoneID = env('PHONE_ID');

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
                file_put_contents("text.txt", json_encode($response));
                
                if(isset($response) && is_object($response) && property_exists($response, 'messages')){
                    // Id del mensaje enviado
                    $idWA = $response['messages'][0]['id'];
    
                    $messageSent = $message;
    
                    // Si recibió el survey
                    if ($survey) {
                        // En el step 1 quiero cambiar el campo contacted a true y reemplazar lo que se almacena como mensaje guardado.
                        if ($step === 1) {
                            $messageSent = 'Inicio encuesta';
    
                            $survey->contacted = true;
                            $survey->save();
                        }
                        // Guardo los datos en la tabla Chatbot
                        Chatbot::insert([
                            'survey_id' => $survey->id,
                            'message_received' => $idReceived,
                            'message_sent' => $messageSent,
                            'id_wa' => $idWA,
                            'phone' => $recipient_phone,
                            'timestamp_wa' => $timestamp,
                            'phone_id' => $client_phone
                        ]);
                    } else {
                        // Para mensajes que no está asociados con un survey, los guardo igual.
    
                        Chatbot::insert([
                            'survey_id' => 0,
                            'message_received' => $messageReceived,
                            'message_sent' => $messageSent,
                            'id_wa' => $idWA,
                            'phone' => $recipient_phone,
                            'timestamp_wa' => $timestamp,
                            'phone_id' => $client_phone
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
        // file_put_contents("text.txt", json_encode($response));
        // Chequea si la respuesta tiene status (lo que quiere decir que no es un mensaje) y sale de la función si lo tiene.
        // Si se quiere verificar lectura o recepcion va por acá
        if (isset($response['entry'][0]['changes'][0]['value']['statuses'][0])) {
            return;
        }

        // Busca tipo de mensaje (interactive o text)
        $replyType = $response['entry'][0]['changes'][0]['value']['messages'][0]['type'];

        // Inicializa variable del mensaje recibido
        $message = false;

        // Obtiene el número del cliente
        $client_phone = $response['entry'][0]['changes'][0]['value']['messages'][0]['from'];

        // Inicializa el survey
        $survey = false;

        if ($replyType === "interactive") {
            // Chequea qué tipo de mensaje interactivo es y obtiene el mensaje
            $type = $response['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['type'];

            if ($type === "button_reply") {
                $message = $response['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['button_reply']['id'];
            } else if ($type === "list_reply") {
                $message = $response['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['list_reply']['id'];
            }

            // Toma el id del mensaje al que responde para identificar la conversación y el survey
            $conversationID = $response['entry'][0]['changes'][0]['value']['messages'][0]['context']['id'];

            if ($conversationID) {
                $conversation = Chatbot::where('id_wa', $conversationID)->first();
                if ($conversation) {
                    $surveyId = $conversation->survey_id;
                    // Find survey 
                    if ($surveyId) {
                        $survey = Survey::find($surveyId);
                    }
                }
            }
        } else if ($replyType === "text") {
            $message = $response['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        }

        // Id del mensaje recibido
        $message_ID = $response['entry'][0]['changes'][0]['value']['messages'][0]['id'];

        $timestamp = $response['entry'][0]['changes'][0]['value']['messages'][0]['timestamp'];

        // Si hay un mensaje continúa
        if ($message != null) {
            /**
             * 1) Respuesta afirmativa al primer mensaje. 
             */
            if ($message === "sendSurvey") {
                /**
                 * 2) Pregunta para calificar
                 */
                $response = $surveyMessages['message1a_text'];

                $dataToSend = $surveyMessages['message1a_buttons'];

                // Guarda en la tabla de survey que el cliente aceptó contestar la encuesta
                if ($survey) {
                    $survey->accepts_survey = true;
                    $survey->save();
                }

                $this->sendWhatsAppMessage($survey, "list", $response, 2, $message_ID, $message, $timestamp, $dataToSend, $client_phone);
            }
            /**
             * 2) Respuesta negativa al primer mensaje. Fin de la encuesta
             */
            else if ($message === 'dontSendSurvey') {

                $response = $surveyMessages['message1b_text'];

                // Guarda la negativa de contestar la encuesta
                if ($survey) {
                    $survey->accepts_survey = false;
                    $survey->save();
                }

                // Envía mensaje de agradecimiento
                $this->sendWhatsAppMessage($survey, "text", $response, 2, $message_ID,  $message, $timestamp, '', $client_phone);
            } else if (strpos($message, 'satisfactionLevel') !== false) {

                // Obtiene el rating
                $rating = substr($message, -1);
                // Lo guarda en la tabla
                if ($survey) {
                    $survey->satisfaction = $rating;
                    $survey->save();
                }

                /**
                 * 3) Si el rating es entre 3 y 5, pregunta palabras
                 */
                if ($rating >= 3) {

                    $response = '¿Qué es lo que más te gustó del servicio?';

                    $dataToSend = [
                        "button" => "Describir",
                        "sections" => [
                            [ 
                                "title" => "Sobre el profesional",
                                "rows" => [
                                    [
                                        "id" => "word:amable",
                                        "title" => "Fue muy amable",
                                        "description" => ""
                                    ],
                                    [
                                        "id" => "word:profesional",
                                        "title" => "Su profesionalidad",
                                        "description" => ""
                                    ],
                                    [
                                        "id" => "word:responsable",
                                        "title" => "Fue responsable",
                                        "description" => ""
                                    ],
                                ]
                            ],
                            [
                                "title" => "Sobre su trabajo",
                                "rows" => [
                                    [
                                        "id" => "word:calificado",
                                        "title" => "Su capacidad",
                                        "description" => ""
                                    ],
                                    [
                                        "id" => "word:creativo",
                                        "title" => "Su creatividad",
                                        "description" => ""
                                    ],

                                ]
                            ]
                        ]
                    ];

                    $this->sendWhatsAppMessage($survey, "list", $response, 3, $message_ID, $message, $timestamp, $dataToSend, $client_phone);
                }
                /**
                 * 3) Si el rating es 1 o 2, envía agradecimiento y mail para contactar. Fin de la encuesta.
                 */
                else {
                    $response = "¡Gracias por responder nuestra encuesta!\nPor cualquier duda o comentario que nos quieras hacer, podés escribirnos a info@cefeperes.com.ar y te contestaremos a la brevedad.";

                    $this->sendWhatsAppMessage($survey, "text", $response, 3, $message_ID, $message, $timestamp, '', $client_phone);
                }
            } else if (strpos($message, 'word:') !== false) {

                // Guarda la palabra en el tabla de survey
                if ($survey) {
                    $response = "¡Gracias por responder nuestra encuesta!\nPor cualquier duda o comentario que nos quieras hacer, podés escribirnos a info@cefeperes.com.ar y te contestaremos a la brevedad.";

                    $word = substr($message, strpos($message, "word:") + strlen("word:"));

                    $descriptiveWords = $survey->descriptive_words;

                    if ($descriptiveWords === null) {
                        $descriptiveWords = [];
                    }

                    $descriptiveWords[] = $word;

                    $survey->descriptive_words = $descriptiveWords;

                    $survey->save();

                    // Envía mensaje de agradecimiento
                    $this->sendWhatsAppMessage($survey, "text", $response, 3, $message_ID, $message, $timestamp, '', $client_phone);

                }
            }
            /**
             * Si el cliente escribe cualquier otra cosa. 
             */
            else {
                $response = 'Por favor, respondé haciendo clic en los botones. Por cualquier duda, podés escribirnos a info@cefeperes.com';

                $this->sendWhatsAppMessage(false, "text", $response, 0, $message_ID, $message, $timestamp, '', $client_phone);
            }
        }
    }

    /**
     * Inicio de la encuesta por whatsapp
     */
    public function initSurvey($surveyId, $id)
    {
        global $surveyMessages;
        // Busca el nombre del profesional
        $user = User::find($id);

        $survey = Survey::find($surveyId);

        $client_phone = $survey->client_cellphone;

        if ($user && $client_phone) {

                $profileName = $user->name . ' ' . $user->last_name;

                // Mensaje inicial
                $initialMessage = str_replace(':profileName', $profileName, $surveyMessages['initialMessage_text']);;

                $dataToSend = $surveyMessages['initialMessage_buttons'];

                $this->sendWhatsAppMessage($survey, "buttons", $initialMessage, 1, '', "", "", $dataToSend, $client_phone);
            
        }
    }
}
