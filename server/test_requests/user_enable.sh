curl --data "username=admin&password=admin" --cookie-jar "cookies.txt" "http://silencio/site/login"
curl -v --data "id_user=42" --cookie "cookies.txt" --cookie-jar "cookies.txt" "http://silencio/user/enable"
