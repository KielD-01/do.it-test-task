# API Docs

### Sign In
`POST /api/sign-in`     
`Content-Type: x-www-form-urlencoded`
`Body { email: string, password: string }`      
**Success Response**
```json
{
    "data": {
        "user": {
            "id": 1,
            "avatar": {
                "main": "/uploads/avatars/user_1/avatar.png",
                "thumbnail": "/uploads/avatars/user_1/thumbnail.png"
            },
            "email": "rom...@yahoo.com",
            "token": "2ce...bfa",
            "api_token": null,
            "created_at": "2018-10-26 18:18:48",
            "updated_at": "2018-10-26 18:18:48"
        },
        "token": "eyJ0eXAiOiJ...NVDQ72tP_GckwNUo"
    },
    "errors": null,
    "status": 200
}
```

**Error Response**
```json
{
    "data": null,
    "errors": [
        "Wrong credentials"
    ],
    "status": 401
}
```

### Sign Up
`POST /api/sign-up`     
`Content-Type: form-data`      
`Body { email: string|required, password: string|required, token: string|required, avatar: file}`      

**Success Response**
```json
{
    "data": {
        "message": "User has been successfully created"
    },
    "errors": [],
    "status": 201
}
```

**Error Response**
```json
{
    "data": [],
    "errors": [
        "The email field is required.",
        "The password field is required.",
        "The token field is required."
    ],
    "message": "Validation errors",
    "status": 422
}
```

```json
{
    "data": [],
    "errors": [
        "The email has already been taken."
    ],
    "message": "Validation errors",
    "status": 422
}
```

### Send Email to Github Users By an Email
`POST /api/github/send/emails`
`Content-Type: x-www-form-urlencoded`
`Body { users: array|required, message: string|required }`  
**Success Response**
```json
{
    "data": {
        "message": "Emails has been sent to the recipients",
        "recipients" : [...]
    },
    "errors" : [],
    "status" : 200
}
```

**Error Response**
```json
{
    "data": [],
    "errors": [
        "The message field is required.",
        "The users must be an array."
    ],
    "message": "Validation|Exception error(-s)",
    "status": 422|400
}
```

### How to login for Mailtrap.io?
Email   `h628025@nwytg.net` (was generated with 10minutes mail)     
Password    `demobox`

`.env.example` file already contains credentials for the fake SMTP server of the MailTrap
