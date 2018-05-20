# MandC_GroundStation

ระบบควบคุมและสนับสนุนการปฎิบัติการภาคพื่นสำหรับดาวเทียม
______________________________________________

## Run Web app on local
  - ติดตั้ง mongodb โดยสามารถทำการติดตั้งตามขั้นตอนต่อไปนี้   [Quick-Start Guide to mLab](https://docs.mongodb.com/manual/tutorial/install-mongodb-on-windows/)
  - นำไฟล์ .json  ไป import เข้า mongodb บน เครื่อง Server
  - เปิด command line ที่ path ที่เก็บไฟล์ จากนั้นรันคำสั่ง php artisan serve 
  - •	เปิดเว็บเบราว์เซอร์ จากพิมพ์ URL ดังนี้ http://localhost:8000
______________________________________________

## Run Web app on heroku
- •	นำไฟล์ .json ไป import เข้า mongodb บน mlab สามารถทำได้ตามลิ้งนี้ [Quick-Start Guide to mLab](https://docs.mlab.com/)
- รันบน Heroku สามารถทำได้ตามลิ้งนี้ [Getting Started on Heroku with PHP](https://devcenter.heroku.com/articles/getting-started-with-php#introduction)