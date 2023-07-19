<?php

global $surveyMessages;

$surveyMessages = [
    'initialMessage_text' => '¡Hola! 👋👋 Te escribimos desde el CEFEPERES.' .
                             ' Hace poco te contactaste con :profileName, de nuestra red de profesionales,' .
                             ' para contratar un servicio y nos encantaría saber cómo fue tu experiencia.' .
                             ' ¿Te gustaría contestar una breve encuesta? ¡Solo llevará unos minutos!',
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
    'message1b_text' => 'Gracias. Si tenés alguna consulta, escribinos a info@cefeperes.com.ar y te contestaremos a la brevedad.'
    
];
