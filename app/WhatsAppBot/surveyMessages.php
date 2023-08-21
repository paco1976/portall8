<?php

global $surveyMessages;

/**
 * initialMessage (Responder encuesta). Botones (nivel 1)
 *          |___ NO (dontSend)  (a) ----- (2a) (finalMessage2)
 *          |___ SI (message1a) (b)
 *                    |___ Pudo concretar acuerdo? (2b)
 *                          |___ NO (message2a)     
 *                                     |___ Por qué   (3a) 
 *                                           |___   FIN (finalMessage2) (4a)    
 *                          |___ SI (message1b)  
 *                                     |___ Calificar (3b) 
 *                                          |___ Calificaciones 4-5 (message1c)  
 *                                          |                         |___  Describir     (4b) 
 *                                                                            |___ escribir    
 *                                          |                                          |___   FIN (finalMessage1) (5)                                                                         
 *                                          |
 *                                          |___ Calificaciones 3   (message1d)                                                                                       
 *                                          |                           |___ escribir     (4c)                                                                           
 *                                          |                                 |___   FIN (finalMessage1) (5)                                                                         
 *                                          |
 *                                          |___ Calificaciones 1-2 (message1e)  (4c)                                                                                      
 *                                                                      |___ escribir    (4d)                                                                                      
 *                                                                            |___   FIN (finalMessage1) (5)                                                                         
 */

$surveyMessages = [
    'initialMessage_text' => "¡Hola! 👋👋 Te escribimos desde el CEFEPERES. \nHace poco te contactaste con *:profileName*, de nuestra red de profesionales y nos gustaría saber cómo fue tu experiencia. \n¿Podrías contestar una breve encuesta? ¡Solo llevará unos minutos! Tu respuesta nos ayuda a mejorar el proyecto.",
    'initialMessage_buttons' => [
        "buttons" => [
            [
                "type" => "reply",
                "reply" => [
                    "id" => "message1a", // Pasa a pregunta concretó o no
                    "title" => "¡Ok!"
                ]
            ],
            [
                "type" => "reply",
                "reply" => [
                    "id" => "dontSendSurvey", // Guarda negativa y pasa a finalMessage2
                    "title" => "No, gracias"
                ]
            ]
        ]
    ],
    'message1a_text' => '¿Pudiste concretar un acuerdo de trabajo con el/la profesional?',
    'message1a_buttons' => [
        "buttons" => [
            [
                "type" => "reply",
                "reply" => [
                    "id" => "message1b", // Pasa a calificar
                    "title" => "Sí"
                ]
            ],
            [
                "type" => "reply",
                "reply" => [
                    "id" => "message2a", // Pasa a por qué no
                    "title" => "No"
                ]
            ]
        ]
    ],
    'message1b_text' => '¿Cómo calificarías el servicio brindado por *:profileName*?',
    'message1b_buttons' => [
        "button" => "Calificar",
        "sections" => [
            [
                "title" => "Calificar",
                "rows" => [
                    [
                        "id" => "rating5", // Pasa a message1c
                        "title" => "⭐⭐⭐⭐⭐",
                        "description" => "¡Excelente!"
                    ],
                    [
                        "id" => "rating4", // Pasa a message1c
                        "title" => "⭐⭐⭐⭐",
                        "description" => "¡Muy bueno!"
                    ],
                    [
                        "id" => "rating3", // Pasa a message1d
                        "title" => "⭐⭐⭐",
                        "description" => "Bueno" 
                    ],
                    [
                        "id" => "rating2", // Pasa a message1e
                        "title" => "⭐⭐",
                        "description" => "Regular" 
                    ],
                    [
                        "id" => "rating1", // Pasa a message1e
                        "title" => "⭐",
                        "description" => "Malo"
                    ]
                ]
            ]
        ]
    ],
    'message1c_text' => "¿Qué es lo que más te gustó del servicio?\n(Podés volver a este mensaje para seleccionar más de una opción).",
    'message1c_buttons' => [
        "button" => "Describir", 
        "sections" => [ 
            [ 
                "title" => "Sobre el profesional",
                "rows" => [
                    [
                        "id" => "word:responsable",
                        "title" => "Responsabilidad",
                        "description" => ""
                    ],
                    [
                        "id" => "word:buen_trato",
                        "title" => "Buen trato",
                        "description" => ""
                    ],
                    [
                        "id" => "word:buen_asesoramiento",
                        "title" => "Buen asesoramiento",
                        "description" => ""
                    ],
                ]
            ],
            [
                "title" => "Sobre su trabajo",
                "rows" => [
                    [
                        "id" => "word:prolijo",
                        "title" => "Prolijidad",
                        "description" => ""
                    ],
                    [
                        "id" => "word:precio_justo",
                        "title" => "Precio justo",
                        "description" => ""
                    ],
                    [
                        "id" => "word:cumplidor",
                        "title" => "Cumplió con lo esperado",
                        "description" => ""
                    ],

                ]
            ]
        ]
    ],     
    'message1d_text' => '¿Qué cosas mejorarías?', // Pasa a finalMessage1
    'message1e_text' => '¿Qué cosas no te gustaron?', // Pasa a finalMessage1
    'message1f_text' => "¿Querés dejarnos una reseña?", // Pasa a finalMessage1 o review
    'message1f_buttons' => [
        "buttons" => [
            [
                "type" => "reply",
                "reply" => [
                    "id" => "review", // Pasa a reseña
                    "title" => "Sí"
                ]
            ],
            [
                "type" => "reply",
                "reply" => [
                    "id" => "no_review", // Pasa a por qué no
                    "title" => "No"
                ]
            ]
        ]
    ],
    'message1g_text' => "Por favor dejanos tu reseña a continuación.\nAl contestar a este mensaje aceptás que tu comentario sea publicado en nuestra página", // Pasa a finalMessage1 o review
    'message2a_text' => "¿Por qué?\n(Podés volver a este mensaje para seleccionar más de una opción).", 
    'message2a_buttons' => [
        "button" => "Ver opciones", 
        "sections" => [  // Pasa a finalMessage2
            [ 
                "title" => "Seleccionar una opción",
                "rows" => [
                    [
                        "id" => "noAgree:no_respondio",
                        "title" => "No me respondió",
                        "description" => ""
                    ],
                    [
                        "id" => "noAgree:no_acordamos_día",
                        "title" => "No pudimos fijar un día",
                        "description" => ""
                    ],
                    [
                        "id" => "noAgree:no_llega_a_zona",
                        "title" => "No llega a mi zona",
                        "description" => ""
                    ],
                    [
                        "id" => "noAgree:caro",
                        "title" => "Me pareció caro",
                        "description" => ""
                    ],
                    [
                        "id" => "noAgree:no_aceptó",
                        "title" => "No aceptó el trabajo",
                        "description" => ""
                    ],
                    [
                        "id" => "noAgree:otra",
                        "title" => "Otra razón",
                        "description" => ""
                    ],
                ]
            ],
        ]
    ],
    'finalMessage1_text' => "¡Gracias por responder nuestra encuesta! Por cualquier duda o comentario que nos quieras hacer, podés escribirnos a portaldeservicioscfo@gmail.com y te contestaremos a la brevedad.",
    'finalMessage2_text' => "Gracias. Si tenés alguna consulta, escribinos a portaldeservicioscfp@gmail.com",
    'aRobot' => "Soy un robot. Por cualquier problema o duda, podés escribirnos a portaldeservicioscfo@gmail.com"    
];
