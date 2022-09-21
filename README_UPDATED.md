### Setup and Installation

1. git clone https://github.com/RHBW174368/kevin_reservation_axdr.git
2. cd kevin_reservation_axdr
3. composer update
4. copy contents of .env_dev to create .env
5. modify .env change database name "axdr_db"
6. php artisan config:clear
7. php artisan cache:clear

### Migrating DB and Seeder

8. php artisan migrate:fresh --seed

### Run Server on Local Machine

9. php artisan server --host=localhost --port=[your port] (Or Any Port Available)

### Testing via POSTMAN 

10. Test Rooms APIs 

### Login via API JWT 
  Method: POST
  URL: http://localhost:8087/api/login
  BODY: form-data
     email: "admin@gmail.com"
     password: "password"
     
### Test Room APIs     

### Show All Rooms 
  METHOD: GET
  URL: http://localhost:[your port]/api/rooms
  Authorization: Bearer Token
  Token: [Generated Token from Login API]

### Get Specific Room
  METHOD: GET
  URL: http://localhost:[your port]/api/rooms/[id here]
  Authorization: Bearer Token
  Token: [Generated Token from Login API]
  
### Store Room
  METHOD: POST
  URL: http://localhost:[your port]/api/rooms/[id here]
  Authorization: Bearer Token
  Token: [Generated Token from Login API]
  Body: form-data
    room_name: "Room 104"
    
### Delete Room
  METHOD: DELETE
  URL: http://localhost:[your port]/api/rooms/[id here]
  Authorization: Bearer Token
  Token: [Generated Token from Login API]
  
  
  
