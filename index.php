<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/simple.css" />
    <title>Document</title>
</head>

<body>
    <header>
        <h1>Image List</h1>
    </header>
    <main>
   
            <?php
                $handle = opendir(__DIR__ . '/images');

                $images = [];
                $allowedExtensions = [
                    'jpg',
                    'jpeg',
                    'png',
                ];
                while (($currentFile = readdir($handle)) !== false) {
                    if ($currentFile === '.' || $currentFile === '..') {
                        continue;
                    }

                    $extension = pathinfo($currentFile, PATHINFO_EXTENSION);
                    if (!in_array($extension, $allowedExtensions)) {
                        continue;
                    }

                    $fileWithTxt = pathinfo($currentFile, PATHINFO_FILENAME) . '.txt';

                    $img_title = null;
                    $img_description = [];

                    if (file_exists(__DIR__ . '/images/' . $fileWithTxt)) {
                        $file_content = file_get_contents(__DIR__ . '/images/' . $fileWithTxt);
            
                        $explode_file_content = explode("\n", $file_content);

                        if(count($explode_file_content) > 0) {
                            $img_title = $explode_file_content[0];
                            // $img_description = implode("\n", array_slice($explode_file_content, 1));

                            unset($explode_file_content[0]);
                            $img_description = array_values($explode_file_content);
                            // var_dump(array_values($explode_file_content));
                        }
                    }

                    $images[] = [
                            'image' => $currentFile,
                            'title' => $img_title,
                            'description' => $img_description
                    ];

                    // break;
                }

                closedir($handle);
            ?>
  

        <?php foreach ($images as $image): ?>
            <figure> 
                <h3><?php echo $image['title'] ?></h3>
                <img src="images/<?php echo rawurlencode($image['image']); ?>" alt="" />
               <figcaption>
                <?php foreach($image['description'] as $description) : ?>
                    <p><?php echo $description ?></p>
                    <?php endforeach; ?>
               </figcaption>
            </figure>
        <?php endforeach; ?>

    </main>
</body>

</html>