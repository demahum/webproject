<?php
require 'flight/Flight.php';

Flight::route('/', function(){
    echo "Welcome to notes.", "<br><br>";
    echo "These are all of the notes available:", "<br>";

    $dom = new DOMDocument('1.0');

    $list = '
    <ol>
    </ol>
    ';

    $host = 'localhost';
    $db   = 'forum';
    $user = 'newuser';
    $pass = 'password';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
         $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
         throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
    $dom->loadHTML($list);
            $stmt = $pdo->query('SELECT * FROM posts');
            while ($row = $stmt->fetch())
            {

                $dom->getElementsByTagName('ol')->item(0)->insertBefore(
                  $dom->createElement('li', $row['title'])
                );
            }

    $new_post = $dom->createElement('input');
    $domAttribute_post = $dom->createAttribute('type');
    $domAttribute_post->value = 'submit';
    $new_post->appendChild($domAttribute_post);
    $domAttribute_value_post = $dom->createAttribute('value');
    $domAttribute_value_post->value = 'new note';
    $new_post->appendChild($domAttribute_value_post);
    $new_form = $dom->createElement('form');
    $domAttribute_new_form = $dom->createAttribute('action');
    $domAttribute_new_form->value="/notes/new";
    $new_form->appendChild($domAttribute_new_form);
    $new_form->appendChild($new_post);
    $dom->appendChild($new_form);

    echo $dom->saveHTML();

});

Flight::route('/notes/new', function(){
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submitAction']))
    {
        $tutorials_dom = new DOMDocument('1.0');

        $home_input = $tutorials_dom->createElement('input');
        $home_input_type = $tutorials_dom->createAttribute('type');
        $home_input_type->value = 'submit';
        $home_input->appendChild($home_input_type);
        $home_input_value = $tutorials_dom->createAttribute('value');
        $home_input_value->value = 'home';
        $home_input->appendChild($home_input_value);
        $home_input_form = $tutorials_dom->createElement('form');
        $home_input_form_action = $tutorials_dom->createAttribute('action');
        $home_input_form_action->value="/";
        $br = $tutorials_dom->createElement('br');
        $home_input_form->appendChild($br);
        $home_input_form->appendChild($home_input_form_action);
        $home_input_form->appendChild($home_input);
        $tutorials_dom->appendChild($home_input_form);

        $host = 'localhost';
        $db   = 'forum';
        $user = 'newuser';
        $pass = 'password';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
             $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
             throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
        $stmt = $pdo->prepare('INSERT INTO posts (title, content, author, submission_date) VALUES (?,?,?, CURRENT_DATE())');
        $stmt->execute([$_POST["title"], "no_content", "no_author"]);

        echo "Your note has been saved.";
        echo $tutorials_dom->saveHTML();
    }
    else
    {

    $tutorials_dom = new DOMDocument('1.0');

    $input_form = $tutorials_dom->createElement('form');
    $input_form_action = $tutorials_dom->createAttribute('action');
    $input_form_action->value="/notes/new";
    $input_form->appendChild($input_form_action);
    $input_form_method = $tutorials_dom->createAttribute('method');
    $input_form_method->value="post";
    $input_form->appendChild($input_form_method);
    $title = $tutorials_dom->createElement('b', "Content: ");
    $input_form->appendChild($title);
    $input = $tutorials_dom->createElement('input');
    $domAttributeGold = $tutorials_dom->createAttribute('type');
    $domAttributeGold->value = 'text';
    $input->appendChild($domAttributeGold);
    $domAttributeGold = $tutorials_dom->createAttribute('name');
    $domAttributeGold->value = 'title';
    $input->appendChild($domAttributeGold);
    $input_form->appendChild($input);
    $br = $tutorials_dom->createElement('br');
    $input_form->appendChild($br);
    $br_second = $tutorials_dom->createElement('br');
    $input_form->appendChild($br_second);
    $submit_input = $tutorials_dom->createElement('input');
    $submit_input_type = $tutorials_dom->createAttribute('type');
    $submit_input_type->value = 'submit';
    $submit_input->appendChild($submit_input_type);
    $submit_input_name = $tutorials_dom->createAttribute('name');
    $submit_input_name->value = 'submitAction';
    $submit_input->appendChild($submit_input_name);
    $submit_input_value = $tutorials_dom->createAttribute('value');
    $submit_input_value->value = 'submit';
    $submit_input->appendChild($submit_input_value);
    $input_form->appendChild($submit_input);
    $tutorials_dom->appendChild($input_form);

    $home_input = $tutorials_dom->createElement('input');
    $home_input_type = $tutorials_dom->createAttribute('type');
    $home_input_type->value = 'submit';
    $home_input->appendChild($home_input_type);
    $home_input_value = $tutorials_dom->createAttribute('value');
    $home_input_value->value = 'home';
    $home_input->appendChild($home_input_value);
    $home_input_form = $tutorials_dom->createElement('form');
    $home_input_form_action = $tutorials_dom->createAttribute('action');
    $home_input_form_action->value="/";
    $home_input_form->appendChild($home_input_form_action);
    $home_input_form->appendChild($home_input);
    $tutorials_dom->appendChild($home_input_form);


    echo $tutorials_dom->saveHTML();
    }
});

Flight::start();
?>
