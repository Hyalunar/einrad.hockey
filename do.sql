ALTER TABLE `teams_liga` CHANGE `aktiv` `aktiv` ENUM('Ja','Nein') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ja';
ALTER TABLE `teams_liga` CHANGE `zweites_freilos` `schiri_freilos` DATE NULL DEFAULT NULL COMMENT '2 Schiris 2 Freilose';
