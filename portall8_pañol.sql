--Pasos Migraciones
--Borra bbdd, Importar datos
--ejecutar migrate, para ejecutar nuevas migraciones, 
--Insertar datos nuevos en estas ultimas tablas creadas

INSERT INTO `states` (`id`, `name`) VALUES
(1, 'Aprovado'),
(2, 'Rechazado'),
(3, 'Pendiente');
(4, 'Finalizado');

INSERT INTO `categoryTools` (`id`, `name`) VALUES
(1, 'Electricos'),
(2, 'Percusion'),


INSERT INTO `tools` (`id`, `name`, `description`,`nameImage`, `state_id`, `categoryTool_id`) VALUES
(1, 'Martillo', 'Amarillo', null, 1, 2);


INSERT INTO `loans` ( `tool_id`, `user_id`, `dateInit`,`dateFinish`, `stateLoans_id`) VALUES
( 1, 30, '2019-10-18 22:44:17', '2019-10-18 22:44:17', 3);

