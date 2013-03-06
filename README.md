Conductrics API in PHP
======================

This wrapper allows the use of the Conductrics REST API from any PHP server.

The code here is written without any assumptions beyond having the base PHP installation, so it will also work on WordPress or any PHP-based system.

Example
-------


    <?php
      // Include the module
      require_once("conductrics/conductrics.php")
      
      // Insert some values from your signup email
      Conductrics::$apiKey = "..."
      Conductrics::$ownerCode = "..."

      // Create an Agent
      $agent = new ConductricsAgent("php-demo-agent");

      // Make a decision
      $choice = $agent.decide(session_id(), "a", "b");

      // Send a reward
      $agent.reward(session_id());
    ?>
