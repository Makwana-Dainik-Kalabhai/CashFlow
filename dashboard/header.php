<div class="header">
    <h1>Expense Dashboard</h1>
    <div class="user-profile">
        <span><?php echo $_COOKIE["name"]; ?></span>
        <h2 class="user-avatar">
            <?php
            $abcd = "abcdefghijklmnopqrstuvwxyz";
            $firstLetter = $_COOKIE["name"][0];
            $i = 1;
            while (!str_contains($abcd, strtolower($firstLetter)) && $i < strlen($_COOKIE["name"])) {
                $firstLetter = $_COOKIE["name"][$i];
                $i++;
            }
            echo strtoupper($firstLetter);
            ?></h2>
    </div>
</div>