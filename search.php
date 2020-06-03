<?php
/*Подключение к БД */
$connect = mysqli_connect("Localhost", "u1064285_users", "Delfa333", "u1064285_port");

if (!mysql_connect(Localhost, u1064285_users, Delfa333)) {
	 exit('Cannot connect to server');
}
if (!mysql_select_db(u1064285_port)) {
	 exit('Cannot select database');
}
function search ($query)
{
    $query = trim($query);
    $query = mysql_real_escape_string($query);
    $query = htmlspecialchars($query);

    if (!empty($query))
    {
        if (strlen($query) < 3) {
            $text = '<p>Слишком короткий поисковый запрос.</p>';
        } else if (strlen($query) > 128) {
            $text = '<p>Слишком длинный поисковый запрос.</p>';
        } else {
            $q = "SELECT *
                  FROM `Ship` WHERE `title` LIKE '%$query%'
                  OR `next` LIKE '%$query%'
                  OR `id` LIKE '%$query%'";

            $result = mysql_query($q);

            if (mysql_affected_rows() > 0) {
                $row = mysql_fetch_assoc($result);
                $num = mysql_num_rows($result);

                $text = '<p>По запросу <b>'.$query.'</b> найдено совпадений: '.$num.'</p>';

                do {
                    // Делаем запрос
                    $q1 = "SELECT `link` FROM `Ship` WHERE `title` = '$row[page_id]'";
                    $result1 = mysql_query($q1);

                    if (mysql_affected_rows() > 0) {
                        $row1 = mysql_fetch_assoc($result1);
                    }

                    $text .= '<p><a> href="'.$row1['link'].'/'.$row['category'].'/'.$row['uniq_id'].'" title="'.$row['title_link'].'">'.$row['title'].'</a></p>
                    <p>'.$row['desc'].'</p>';

                } while ($row = mysql_fetch_assoc($result));
            } else {
                $text = '<p>По вашему запросу ничего не найдено.</p>';
            }
        }
    } else {
        $text = '<p>Задан пустой поисковый запрос.</p>';
    }

    return $text;
}
?>
