<script language="JavaScript">

    function office_names() {

        var select = document.form.office_name;
        var groups_select = document.form.group_name;
        var users_select = document.form.user_name;
        select.options[0] = new Option("All");
        select.options[0].value = 'All';

        <?php

        @$office_name = $_POST['office_name'];

        $query = "select * from ".$db_prefix."offices";
        $result = mysqli_query($db, $query);

        $cnt=1;
        while ($row=mysqli_fetch_array($result)) {
          if ("".$row['officename']."" == stripslashes($office_name)) {
          echo "select.options[$cnt] = new Option(\"".$row['officename']."\",\"".$row['officename']."\", true, true);\n";
          } else {
          echo "select.options[$cnt] = new Option(\"".$row['officename']."\");\n";
          echo "select.options[$cnt].value = \"".$row['officename']."\";\n";
          }
          $cnt++;
        }
        ?>
    }

    function group_names() {

        var offices_select = document.form.office_name;
        var groups_select = document.form.group_name;
        var users_select = document.form.user_name;
        groups_select.options[0] = new Option("All");
        groups_select.options[0].value = 'All';
        users_select.options[0] = new Option("All");
        users_select.options[0].value = 'All';

        if (offices_select.options[offices_select.selectedIndex].value != 'All') {
            groups_select.length = 0;
        }

        <?php
        @$group_name = $_POST['group_name'];

        $query = "select * from ".$db_prefix."offices";
        $result = mysqli_query($db, $query);

        while ($row=mysqli_fetch_array($result)) {
        $office_row = addslashes("".$row['officename']."");
        ?>

        if (offices_select.options[offices_select.selectedIndex].text == "<?php echo $office_row; ?>") {
            <?php
            $query2 = "select * from ".$db_prefix."offices, ".$db_prefix."groups where ".$db_prefix."groups.officeid = ".$db_prefix."offices.officeid
                       and ".$db_prefix."offices.officename = '".$office_row."'";
            $result2 = mysqli_query($db, $query2);
            echo "groups_select.options[0] = new Option(\"All\");\n";
            echo "groups_select.options[0].value = 'All';\n";
            $cnt = 1;

            while ($row2=mysqli_fetch_array($result2)) {
              $groups = "".$row2['groupname']."";
              echo "groups_select.options[$cnt] = new Option(\"$groups\");\n";
              echo "groups_select.options[$cnt].value = \"$groups\";\n";
              $cnt++;
            }

            ?>
        }
        <?php
        }
        ?>
        if (users_select.options[users_select.selectedIndex].value != 'All') {
            users_select.length = 0;
        }
        if (groups_select.options[groups_select.selectedIndex].value != 'All') {
            groups_select.length = 0;
        }
        if (offices_select.options[offices_select.selectedIndex].value == 'All') {
            <?php
            echo "groups_select.options[0] = new Option(\"All\");\n";
            echo "groups_select.options[0].value = 'All';\n";
            ?>
        }
        if (groups_select.options[groups_select.selectedIndex].value == 'All') {
            <?php
            echo "users_select.options[0] = new Option(\"All\");\n";
            echo "users_select.options[0].value = 'All';\n";
            ?>
        }
    }

    function user_names() {
        var offices_select = document.form.office_name;
        var groups_select = document.form.group_name;
        var users_select = document.form.user_name;
        users_select.options[0] = new Option("All");
        users_select.options[0].value = 'All';

        if (offices_select.options[offices_select.selectedIndex].value != 'All') {
            users_select.length = 0;
        }

        <?php

        $query = "select * from ".$db_prefix."offices order by officename asc";
        $result = mysqli_query($db, $query);

        while ($row=mysqli_fetch_array($result)) {
        $office_row = addslashes("".$row['officename']."");
        ?>
        if (offices_select.options[offices_select.selectedIndex].text == "<?php echo $office_row; ?>") {
            <?php
            $query2 = "select * from ".$db_prefix."offices, ".$db_prefix."groups where ".$db_prefix."groups.officeid = ".$db_prefix."offices.officeid
                       and ".$db_prefix."offices.officename = '".$office_row."'
                       order by ".$db_prefix."groups.groupname asc";
            $result2 = mysqli_query($db, $query2);
            while ($row2=mysqli_fetch_array($result2)) {
            $groups = "".$row2['groupname']."";
            ?>

            if (groups_select.options[groups_select.selectedIndex].text == "<?php echo $groups; ?>") {
                <?php
                $query3 = "select * from ".$db_prefix."employees where office = '".$office_row."' and groups = '".$groups."' and empfullname <> 'admin'
                           order by empfullname asc";
                $result3 = mysqli_query($db, $query3);

                echo "users_select.options[0] = new Option(\"All\");\n";
                echo "users_select.options[0].value = 'All';\n";
                $usercnt = 1;

                while ($row3=mysqli_fetch_array($result3)) {
                $users = "".$row3['empfullname']."";
                echo "users_select.options[$usercnt] = new Option(\"$users\");\n";
                echo "users_select.options[$usercnt].value = \"$users\";\n";
                $usercnt++;
                } // ends while $row3 for users
                ?>
            }
            <?php
            } // ends while $row2 for groups
            ?>
        }
        <?php
        }// ends while $row for offices
        ?>
        if (groups_select.options[groups_select.selectedIndex].value == 'All') {
            <?php
            echo "users_select.options[0] = new Option(\"All\");\n";
            echo "users_select.options[0].value = 'All';\n";
            ?>
        }
    }

</script>
