<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Helper to fetch a single integer scalar (e.g. COUNT(*))
    function fetchScalar(mysqli $conn, string $sql, string $types = '', array $params = []): int
    {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Prepare failed: " . $conn->error);
        }
        if ($types !== '') {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $stmt->bind_result($value);
        $stmt->fetch();
        $stmt->close();
        return (int)$value;
    }

    // Helper to fetch total up/down-votes for a table
    function fetchVotesStats(mysqli $conn, string $table): array
    {
        $sql = "
            SELECT
                COALESCE(SUM(upvotes), 0)   AS yes_votes,
                COALESCE(SUM(downvotes), 0) AS no_votes
            FROM `$table`
        ";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Prepare failed: " . $conn->error);
        }
        $stmt->execute();
        $stmt->bind_result($yes, $no);
        $stmt->fetch();
        $stmt->close();
        return ['yes' => (int)$yes, 'no' => (int)$no];
    }

    // Helper to fetch the top-voted item from a table (global)
    function fetchTopGlobal(mysqli $conn, string $table): array
    {
        $sql = "
            SELECT
                name            AS item_name,
                upvotes         AS item_votes,
                downvotes       AS item_downvotes,
                image_path      AS item_image
            FROM `$table`
            WHERE upvotes = (
                SELECT COALESCE(MAX(upvotes), 0)
                FROM `$table`
            )
            LIMIT 1
        ";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Prepare failed: " . $conn->error);
        }
        $stmt->execute();
        $stmt->bind_result($name, $votes, $down, $img);
        if (!$stmt->fetch()) {
            // no rows
            $name = null; $votes = 0; $down = 0; $img = null;
        }
        $stmt->close();
        return [
            'item_name'      => $name,
            'item_votes'     => (int)$votes,
            'item_downvotes' => (int)$down,
            'item_image'     => $img,
        ];
    }

    // 1) Global totals
    $totalProducts = fetchScalar($conn, "SELECT COUNT(*) FROM products");
    $totalServices = fetchScalar($conn, "SELECT COUNT(*) FROM services");
    
    $totalResidents = fetchScalar(
        $conn,
        "SELECT COUNT(*) FROM users WHERE role = ?",
        's',
        ['resident']
    );
    $totalSMEs = fetchScalar(
        $conn,
        "SELECT COUNT(*) FROM users WHERE role = ?",
        's',
        ['business']
    );
    $totalCouncils = fetchScalar(
        $conn,
        "SELECT COUNT(*) FROM users WHERE role = ?",
        's',
        ['council']
    );

    // 2) Global vote sums
    $prodVotes = fetchVotesStats($conn, 'products');
    $svcVotes  = fetchVotesStats($conn, 'services');
    $totalYesVotes = $prodVotes['yes'] + $svcVotes['yes'];
    $totalNoVotes  = $prodVotes['no']  + $svcVotes['no'];

    // Add these two lines:
    $totalItems      = $totalProducts + $totalServices;    // total products & services
    $totalVotes      = $totalYesVotes + $totalNoVotes; 


    // 3) Top-voted product & service (global)
    $topProduct = fetchTopGlobal($conn, 'products');
    $topService = fetchTopGlobal($conn, 'services');

    // 4) Decide overall “highest-voted” between product & service
    if ($topService['item_votes'] >= $topProduct['item_votes']) {
        $winner     = $topService;
        $winnerType = 'service';
    } else {
        $winner     = $topProduct;
        $winnerType = 'product';
    }

    $conn->close();

} catch (RuntimeException $e) {
    // In production, log $e->getMessage()
    echo '<p>Sorry, something went wrong.</p>';
    exit;
}

// Now you have:
//   $totalProducts, $totalServices, $totalResidents, $totalSMEs, $totalCouncils
//   $totalYesVotes, $totalNoVotes
//   $winner['item_name'], $winner['item_votes'], $winner['item_downvotes'], $winner['item_image']
//   $winnerType ('product' or 'service')

?>




<div class="dashboard-content admin-dashboard-overview">
    <div class="overview-container">
        <div class="heading-container">
            <h2 class="content-main-heading">
                Dashboard Overview
            </h2>
        </div>
        <div class="admin-card-container">
            <div class="card total-residents">
                <h3 class="card-heading">
                    Total Residents
                </h3>
                <p class="total-registerd total">
                    Registered individuals who vote on products/services
                </p>
                <h4 class="count">
                <?= $totalResidents ?>
                </h4>
            </div>
            <div class="card total-smes">
                <h3 class="card-heading">
                    Total SMEs
                </h3>
                <p class="total-approved total">
                    Approved wellness product and service providers
                </p>
                <h4 class="count">
                <?= $totalSMEs ?>
                </h4>
            </div>
            <div class="card total-coucil">
                <h3 class="card-heading">
                    Total Councils
                </h3>
                <p class="total-local total">
                    Local councils that have onboarded and added areas
                </p>
                <h4 class="count">
                <?= $totalCouncils ?>
                </h4>
            </div>
            <div class="card total-products">
                <h3 class="card-heading">
                    Total Products/Services
                </h3>
                <p class="total-combine total">
                    Combined number of listed wellness offerings
                </p>
                <h4 class="count">
                <?php echo $totalItems; ?>
                </h4>
            </div>
            <div class="card total-votes">
                <h3 class="card-heading">
                    Total Votes
                </h3>
                <p class="total-cast total">
                    All Yes/No votes cast by residents so far
                </p>
                <h4 class="count">
                <?= $totalVotes ?> 
                </h4>
            </div>
            <div class="card total-top">
                <h3 class="card-heading">
                    Top Voted Product
                </h3>
                <p class="total-412 total">
                    With <?= $winner['item_votes'] ?> Yes votes and <?= $winner['item_downvotes'] ?> No votes
                </p>
                <h4 class="count">
                <?= htmlspecialchars($winner['item_name']) ?>
                </h4>
            </div>
        </div>

    </div>
</div>
</div>