curl --data "username=admin&password=admin" --cookie-jar "cookies.txt" "http://silencio/site/login"
curl --cookie "cookies.txt" --cookie-jar "cookies.txt" "http://silencio/user/list"
