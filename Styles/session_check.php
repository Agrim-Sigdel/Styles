<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please log in first!";
    exit;
}