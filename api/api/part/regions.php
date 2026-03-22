<?php
function api_regions($conn) {
    $conn = reconnectdb($conn);
    $response = [];

    $regionQuery = "SELECT * FROM `regions` ORDER BY id ASC";
    $regionResult = mysqli_query($conn, $regionQuery);

    while ($rawRegion = mysqli_fetch_assoc($regionResult)) {
        $region = htmlsan($rawRegion);
        $region_id = $rawRegion['id'];

        $coordQuery = "SELECT x, y, z FROM region_coords WHERE region_id=$region_id ORDER BY seq ASC";
        $coordResult = mysqli_query($conn, $coordQuery);

        $xs = [];
        $ys = [];
        $zs = [];
        while ($coord = mysqli_fetch_assoc($coordResult)) {
            $xs[] = (int)$coord['x'];
            $ys[] = (int)$coord['y'];
            $zs[] = (int)$coord['z'];
        }

        if (count($xs) < 3) continue;

        $main_dial = empty($region['main_dial']) ? "N/A" : $region['main_dial'];
        $owners    = empty($region['owners'])    ? "Unknown" : $region['owners'];
        $members   = empty($region['members'])   ? "None" : $region['members'];
        $railways  = empty($region['railways'])  ? "None" : $region['railways'];
        $wiki      = empty($region['wiki'])      ? "" : $region['wiki'];
        $info      = empty($region['info'])      ? "" : $region['info'];

        $desc  = "<div class=\"dial-box\">";
        $desc .= "<h1 class=\"dial-name\">" . $region['name'] . "</h1>";
        $desc .= "<div class=\"dial-bar\"></div>";
        $desc .= "<p class=\"dial-dial\">/dial " . $main_dial . "</p>";
        if (!empty($info)) {
            $desc .= "<p class=\"dial-info\">" . $info . "</p>";
        }
        $desc .= "<p class=\"dial-coord\">Owners: " . $owners . "</p>";
        $desc .= "<p class=\"dial-coord\">Members: " . $members . "</p>";
        $desc .= "<p class=\"dial-coord\">Railways: " . $railways . "</p>";
        if (!empty($wiki)) {
            $desc .= "<p class=\"dial-wiki\"><a href=\"" . $wiki . "\">" . $wiki . "</a></p>";
        }
        $desc .= "</div>";

        $response[$region_id] = [
            "color"       => $rawRegion['color'],
            "fillcolor"   => $rawRegion['color'],
            "opacity"     => 0.3,
            "fillopacity" => 0,
            "weight"      => 2,
            "markup"      => false,
            "label"       => $region['name'],
            "desc"        => $desc,
            "x"           => $xs,
            "y"           => max($ys),
            "z"           => $zs,
            "ytop"        => max($ys),
            "ybottom"     => min($ys),
        ];
    }

    return $response;
}
?>
