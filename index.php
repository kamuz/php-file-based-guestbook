<?php
error_reporting(-1);

// Print array
function dd( $array ) {
    echo '<pre>';
    print_r( $array );
    echo '</pre>';
}

// Save message to file
function save_message() {
    $str = $_POST['name'] . '|' . $_POST['message'] . '|' . date('Y-m-d H:i:s') . "\n***\n";
    file_put_contents( 'gb.txt', $str, FILE_APPEND );
}

// Get messages from file
function get_messages() {
    return file_get_contents( 'gb.txt' );
}

// Split messages to arrays
function array_messages( $messages ) {
    $messages = explode( "\n***\n", $messages );
    // Delete last empty element
    array_pop( $messages );
    // Reverse messages
    return array_reverse( $messages );
}

// Spite message to array
function array_message( $message ) {
    return explode( '|', $message );
}

if ( $_POST ) {
    save_message();
    header("Location: {$_SERVER['PHP_SELF']}" );
    exit;
}

$messages = get_messages();
$messages = array_messages( $messages );

// dd( $messages );

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Test</title>
    <style>
        form {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #eee;
        }
        label {
            display: block;
        }
        input[type="text"],
        textarea {
            outline: none;
            display: block;
            width: auto;
            margin-bottom: 10px;
            font-family: sans-serif;
            border: 1px solid #ccc;
            padding: 5px;
            width: calc(100% - 10px);
        }
        button {
            border: none;
            background-color: green;
            color: #fff;
            padding: 5px 10px;
            cursor: pointer;
        }
        .container {
            max-width: 500px;
            margin: auto;
        }
        .message {
            border: 1px solid #eee;
            padding: 10px;
            margin-bottom: 10px;
        }
        .meta {
            font-size: 90%;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="index.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Your name" required>
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="5" placeholder="Say something" required></textarea>
            <div><button type="submit">Send</button></div>
        </form>
        <?php if ( ! empty( $messages ) ) : ?>
            <div class="messages">
                <?php foreach( $messages as $message ) : ?>
                    <div class="message">
                        <?php $message = array_message( $message ); ?>
                        <?php // dd( $message ); ?>
                        <div class="meta"><strong><?php echo $message[0] ?></strong> | <i>Published</i>: <?php echo $message[2] ?></div>
                        <div class="divider">-----</div>
                        <div class="text"><?php echo nl2br( htmlspecialchars( $message[1] ) ); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>