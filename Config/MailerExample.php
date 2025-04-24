<?php

namespace Config;

class MailerExample
{
    protected static string $host = "smtp.gmail.com";
    protected static int $port = 465;
    protected static string $email = "postmaster@example.com";
    protected static string $password = "notmypassword";
    protected static string $name = "Artifex";
    protected static bool $secure = true;
    protected static bool $auth = true;
}