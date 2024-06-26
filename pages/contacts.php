<h1>Contacts</h1>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clear($_POST['name'] ?? '');
    $email = clear($_POST['email'] ?? '');
    $message = clear($_POST['message'] ?? '');
    $flag_empty = false;

    if (empty($name)) {
        $_SESSION['name_validation'] = ['Name is required', 'danger'];
        $flag_empty = true;
    }

    if (empty($email)) {
        $_SESSION['email_validation'] = ['Email is required', 'danger'];
        $flag_empty = true;
    }

    if (empty($message)) {
        $_SESSION['message_validation'] = ['Message is required', 'danger'];
        $flag_empty = true;
    }

    if ($flag_empty) {
        $_SESSION['Name'] = empty($name) ? '' : $name;
        $_SESSION['Email'] = empty($email) ? '' : $email;
        $_SESSION['Message'] = empty($message) ? '' : $message;
    } else {
        mail("moneysalnik27@gmail.com", "Data", "$name $email $message");
        $_SESSION['userMes'] = ["Message's sent successfully!", 'success'];
        unset($_SESSION['Name']);
        unset($_SESSION['Email']);
        unset($_SESSION['Message']);
    }
    redirect("contacts");
}

?>

<?php

show_session_data('userMes');

?>

<form action="/contacts" method="POST">
    <div class="mb-3">
        <?php

        show_session_data('name_validation');

        ?>
        <label for="form-label">Name:</label>
        <input type="text" name="name" class="form-control" value="<?= $_SESSION['Name'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <?php
        show_session_data('email_validation');
        ?>
        <label for="form-label">Email:</label>
        <input type="text" name="email" class="form-control" value="<?= $_SESSION['Email'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <?php
        show_session_data('message_validation');
        ?>
        <label for="form-label">Message:</label>
        <textarea class="form-control" name="message"><?= $_SESSION['Message'] ?? '' ?></textarea>
    </div>

    <button class="btn btn-primary mt-3">Send</button>
</form>