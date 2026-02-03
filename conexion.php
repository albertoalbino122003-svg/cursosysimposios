<?php

            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $bdname = 'cursosysimposios';

            $conex = new mysqli($servername, $username, $password, $bdname);

        if ($conex->connect_error) {
            die("Connection failed: " . $conex->connect_error);
        }

            if (!$conex->set_charset("utf8")) {
                printf("Error al cargar el conjunto de caracteres utf8: %s\n", $conex->error);
            exit();
        }

?>
