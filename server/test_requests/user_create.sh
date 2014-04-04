curl --data "username=admin&password=admin" --cookie-jar "cookies.txt" "http://silencio/site/login"
curl --data "username=a1&password=a1&name=b1&email=c1&telephone=d1" --cookie "cookies.txt" --cookie-jar "cookies.txt" "http://silencio/user/create"
curl --cookie "cookies.txt" --cookie-jar "cookies.txt" "http://silencio/site/logout"
curl --data "username=a&password=a&name=b&email=c&telephone=d&tags[]=1&tags[]=2" "http://silencio/user/create"
