<footer class="footer">
    <?php
    $messagesA = [
        "&copy; 2026 Dakto INC. All rights reserved.",
    ];
 $messagesB = [
     "Novymap is enterprise grade software <span class='spoiler'>in terms of technical debt.</span>",
    ];

    echo "<p>" . $messagesB[array_rand($messagesB)] ;
    echo "<br>" . $messagesA[array_rand($messagesA)] . "</p>";
    ?>
</footer>
