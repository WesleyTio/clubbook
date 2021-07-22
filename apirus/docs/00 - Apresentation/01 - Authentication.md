---
title: Authentication
method: POST
url: "{{API_URL}}/login"
---

Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

```request:cURL
curl --location --request POST '{{API_URL}}/login' \
--header 'Content-Type: application/json' \
--data-raw '{
	"email": "fulano@email.com",
	"password": "123456"
}'
```

```request:PHP
import requests

url = "{{API_URL}}/login"

payload = "{\"username\": \"vaneves\", \"password\": \"123456\"\n}"
headers = {
  'Content-Type': 'application/json'
}

response = requests.request("POST", url, headers=headers, data = payload)

print(response.text.encode('utf8'))
```

```response:200
{
	"user"    : "name"
    "userId"  : "userId",
    "success" : "true",
    "message" : "Usuario logado com sucesso"
}
```

```response:401
{
	"success" : "false",
    "message" : "Email ou senha inválidos "
}
```
