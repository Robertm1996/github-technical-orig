<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Document</title>
</head>

<body>
    <form method="get" action="">
        Name: <input type="text" name="fname">
        <input type="submit">
    </form>

    <?php
    $user = isset($_REQUEST['fname']) ? trim($_REQUEST['fname']) : '';
    ?>



    <h3 >GitHub API</h3>
    <?php
    if (!empty($user)) {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.github.com/search/users?q=' . $user,
            CURLOPT_USERAGENT => 'Github API in CURL'
        ]);

        $response1 = curl_exec($curl);

        $response_array1 = ((array) json_decode($response1, true));
        
        // print_r($response_array1);
        $key = 'items';
        $value1 = $response_array1[$key][0];
        // print_r($value);
        $key2 = 'login';
        $name = $value1[$key2];
        //print_r($name);
        $key3 = 'url';
        $url = $value1[$key3];
        $key4 = 'avatar_url';
        $img_url = $value1[$key4];
        $key5 = 'score';
        $score = $value1[$key5];

    ?>

        <img src=<?php echo $img_url ?> alt="" style="width: 150px;" class="feature-logo" />

        <a href="
                <?php
                print_r($url);
                ?>
                " class="test">
            
                <?php
                print_r($name);
                ?>
        </a>

        <?php
        curl_close($curl);
        ?>

        <h2>
            User's Top 5 Repositories:
        </h2>

        <p style="overflow-wrap: break-word;">

            <?php
            try {
                $curl2 = curl_init();

                curl_setopt_array($curl2, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://api.github.com/users/' . $user . '/repos',
                    CURLOPT_USERAGENT => 'Github API in CURL'
                ]);

                $response = curl_exec($curl2);

                $response_array2 = ((array) json_decode($response, true));

                $sorted = array_column($response_array2, 'stargazers_count');

                array_multisort($sorted, SORT_DESC, $response_array2, SORT_DESC);

                $num_of_items = count($response_array2);

                $size_limit = 5;

                for ($i = 0; $i < $num_of_items && $i < $size_limit; $i++) {
                    $response_item = $response_array2[$i];
                    $key = 'name';
                    $value2 = $response_item[$key];
                    echo $value2;
                    $key2 = 'stargazers_count';
                    $value3 = $response_item[$key2];
                    echo " (Stars: " . $value3 . ")";
                    if ($i < ($num_of_items - 1)) {
                        echo  nl2br("\n");
                    }
                }
                curl_close($curl2);
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            ?>
        </p>
    <?php
    }
    ?>
</body>

</html>