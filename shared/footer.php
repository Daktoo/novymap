<footer class="footer">
    <?php
    $messagesA = [
        "&copy; 2025 me. Your Mum reserved.",
        "&copy; 2025 me. Most rights reserved.",
        "&copy; 2025 me. All rights reserved.",
        "&copy; 2025 me. Some rights reserved.",
        "&copy; 2025 me. No rights reserved.",
        "&copy; 2025 me. All your rights belong to us.",
        "&copy; 2025 me. No warranty. No liability. No refunds. <br> No returns. No exchanges. No guarantees. No support. No service. No maintenance.",
    ];
 $messagesB = [
     "Novymap-qvh is enterprise grade software <span class='spoiler'>in term of technical debt.</span>",
     "Novymap was using LAMPL (Linux Apache MariaDB PHP Leaflet) <br> but Novymap-qvh is using LNMPPLOFV (Linux Nginx MariaDB PostgreSQL PHP LiveAtlas Oauth2-proxy Forgejo Varnish).",
     "Novymap-qvh has zero downtime on deployments just like enterprise software <br><span class='spoiler'> (100% totally not because of the dev do development in production) </span>",
     "Novymap-qvh is the toppest hence <a href=\"https://www.novymap-qvh.top\">https://www.novymap-qvh.top/</a> <br><span class='spoiler'>  (100% totally not because of some hype person saw it cheap and get it) </span> "
    ];

    echo "<p>" . $messagesB[array_rand($messagesB)] ;
    echo "<br>" . $messagesA[array_rand($messagesA)] . "</p>";
    ?>
</footer>
