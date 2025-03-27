<?php

require_once __DIR__ . '/ContactForm.php';

$form = new ContactForm();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
    $asunto = isset($_REQUEST['asunto']) ? $_REQUEST['asunto'] : "";
    $contenido = isset($_REQUEST['contenido']) ? $_REQUEST['contenido'] : "";

    $form->setData($email, $asunto, $contenido);

    if ($form->validate()) {
        if ($form->send()) {
            presentoFeedback("", $form->getExito());
            presentoForm("", "", "");
        } else {
            presentoFeedback($form->getError(), "");
            presentoForm($email, $asunto, $contenido);
        }
    } else {
        presentoFeedback($form->getError(), "");
        $data = $form->getData();
        presentoForm($data['email'], $data['asunto'], $data['contenido']);
    }
} else {
    presentoFeedback("", "");
    presentoForm("", "", "");
}
