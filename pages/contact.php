<?php
$title = 'Contact';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['captcha']) || !is_numeric($_POST['captcha']) || $_POST['captcha'] != ($_SESSION['captcha_number1'] - $_SESSION['captcha_number2'])) {
        $body = <<<HTML
        <div class="page-section">
            <p><strong>Captcha Failed</strong></p>
            <p>It looks like the answer to the captcha was incorrect. Please go back and try again.</p>
        </div>
        HTML;
    } else {
        if(isset($_POST['name'])) {
            $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
        } 
        if(isset($_POST['email'])) {
            $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        }
        if(isset($_POST['message'])) {
            $message = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');
        }
        
        if($name && $email && $message) {
            mail($email, "New message from contact form", $name . " says:\n\n" . $message);
            $body = <<<HTML
            <div class="page-section">
                <p>Thank you, <strong>{$name}</strong>, for reaching out! Your message has been submitted. I'll get back to you at <strong>{$email}</strong> as soon as I can.</p>
                <p>In the meantime, feel free to explore the site and check out some of the tools and projects I've shared.</p>
            </div>
            HTML;
        } else {
            $body = <<<HTML
            <div class="page-section">
                <p><strong>Invalid Input</strong></p>
                <p>Please make sure to fill out all fields correctly. Go back and try again.</p>
            </div>
            HTML;
            echo $body;
            exit;
        }
    }
} else {

$_SESSION['captcha_number1'] = rand(50, 99);
$_SESSION['captcha_number2'] = rand(1, 49);
$body = <<<HTML

<div class="page-section">
    <form method="post" class="contact-form">
        <h2>Contact Me</h2>
        <p>If you have any questions, suggestions, or just want to say hi, feel free to reach out using the form below!</p>
        <div class="form-section">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required />
        </div>
        <div class="form-section">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />
        </div>
        <div class="form-section">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <div class="form-section">
            <label for="captcha">What is {$_SESSION['captcha_number1']} - {$_SESSION['captcha_number2']}?</label>
            <input type="number" id="captcha" name="captcha" required />
            <div class="note">This is to prevent spam. Please solve the math problem above.</div>
        </div>
        <button type="submit">Send Message</button>
    </form>
</div>

HTML;
}
?>