curl --data "id_case=7lc8d&id_mobile=a&text=XXX2" "http://silencio/case/response"
curl --data "id_case=6q270&password=b&text=XXX2" "http://silencio/case/response"
curl --data "username=a1&password=a1"  --cookie-jar "cookies.txt" "http://silencio/site/login"
curl --data "id_case=6q270&text=YYY" --cookie "cookies.txt" --cookie-jar "cookies.txt" "http://silencio/case/response"
