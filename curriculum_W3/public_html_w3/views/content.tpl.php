<!DOCTYPE html>
<html lang='ja'>
    <?php include('header.inc.php'); ?>
    <body>

        <h1><?= $message ?></h1>
        
        <!-- 下記が追記箇所 -->
        <?php foreach($results as $player){ ?>
            <p> <?php print_r($player); ?> </p>
        <?php } ?>

        <?php include('footer.inc.php'); ?>
    </body>
</html>
