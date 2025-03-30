<?php

$to = "teste@matcha.com";
$subject = "🧪 Teste de Email Matcha";
$message = "Este é um email de teste do sistema Matcha.";
$headers = "From: matcha@localhost";

if (mail($to, $subject, $message, $headers))
{
    echo "✅ Email enviado com sucesso!";
}
else
{
    echo "❌ Falha ao enviar email.";
}
