<?php

global $surveyMessages;

$surveyMessages = [
    'initialMessage_text' => "¡Hola! 👋👋 Te escribimos desde el CEFEPERES. \nHace poco te contactaste con *:profileName*, de nuestra red de profesionales, para contratar un servicio y nos encantaría saber cómo fue tu experiencia. \n¿Te gustaría contestar una breve encuesta? ¡Solo llevará unos minutos!",
    'initialMessage_buttons' => [
        "buttons" => [
            [
                "type" => "reply",
                "reply" => [
                    "id" => "sendSurvey",
                    "title" => "¡Ok!"
                ]
            ],
            [
                "type" => "reply",
                "reply" => [
                    "id" => "dontSendSurvey",
                    "title" => "No, gracias"
                ]
            ]
        ]
    ],
    'message1a_text' => '¿Cómo calificarías su nivel de atención?',
    'message1a_buttons' => [
        "button" => "Calificar",
        "sections" => [
            [
                "title" => "Calificaciones",
                "rows" => [
                    [
                        "id" => "satisfactionLevel5",
                        "title" => "😁",
                        "description" => "¡Excelente!"
                    ],
                    [
                        "id" => "satisfactionLevel4",
                        "title" => "🙂",
                        "description" => "¡Muy buena!"
                    ],
                    [
                        "id" => "satisfactionLevel3",
                        "title" => "😐",
                        "description" => "Regular"
                    ],
                    [
                        "id" => "satisfactionLevel2",
                        "title" => "😕",
                        "description" => "Mala"
                    ],
                    [
                        "id" => "satisfactionLevel1",
                        "title" => "😠",
                        "description" => "Pésima"
                    ]
                ]
            ]
        ]
                    ],
    'message1b_text' => 'Gracias. Si tenés alguna consulta, escribinos a info@cefeperes.com.ar y te contestaremos a la brevedad.',
    'message2a_text' => '¿Qué es lo que más te gustó del servicio?',
    'message2a_buttons' => [
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
                ],
    'finalMessage_text' => "¡Gracias por responder nuestra encuesta! \nPor cualquier duda o comentario que nos quieras hacer, podés escribirnos a info@cefeperes.com.ar y te contestaremos a la brevedad.",
];
