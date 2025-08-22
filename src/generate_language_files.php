<?php

chdir(__DIR__);

require __DIR__ . '/../bootstrap.php';

$languageBatchBo = new \Language\LanguageBatchBo();
$languageBatchBo->generateLanguageFiles();
$languageBatchBo->generateAppletLanguageXmlFiles();