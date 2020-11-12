<?php

// логирование запросов log.txt
file_put_contents('log.txt', file_get_contents('php://input'));