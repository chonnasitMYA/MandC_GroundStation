using MongoDB.Driver;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Windows.Forms;
using Telegram.Bot;

namespace MTCP
{
    static class Program
    {
        private static readonly TelegramBotClient Bot = new TelegramBotClient("572794128:AAGve89M6IRZc3-H5fBWgU66lMTFuPxg49c");
        /// <summary>
        /// The main entry point for the application.
        /// </summary>
        [STAThread]
        static void Main()
        {
            Bot.StartReceiving();
            Bot.OnMessage += Bot_OnMessage;
            Bot.OnMessageEdited += Bot_OnMessage;

            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new Form1());
            
            Bot.StopReceiving();

        }
        private static void Bot_OnMessage(object sendar, Telegram.Bot.Args.MessageEventArgs e)
        {
            var conString = "mongodb://localhost:27017";
            var Client = new MongoClient(conString);
            var DB = Client.GetDatabase("SatelliteDB");

            var collectionControlTime = DB.GetCollection<getDataControlTime>("ControlTime");
            var data = collectionControlTime.AsQueryable<getDataControlTime>().ToList();

            int round = 0;
            var text = "";
            foreach (var datacontrol in data)
            {
                round = round + 1;
                var dateTempStart = "";
                var tempFreeStart = datacontrol.timestart.Split(' ');
                var DayFreeStart = tempFreeStart[0].Split('/');
                dateTempStart = DayFreeStart[1] + '/' + DayFreeStart[0] + '/' + DayFreeStart[2] + ' ' + tempFreeStart[1];

                var dateTempEnd = "";
                var tempFreeEnd = datacontrol.timestop.Split(' ');
                var DayFreeEnd = tempFreeEnd[0].Split('/');
                dateTempEnd = DayFreeEnd[1] + '/' + DayFreeEnd[0] + '/' + DayFreeEnd[2] + ' ' + tempFreeEnd[1];

                text = text + ("ดาวเทียม : " + datacontrol.namesatellite + "\r\n");
                text = text + ("เวลาเริ่มต้น : " + dateTempStart + "\r\n");
                text = text + ("เวลาสิ้นสุด : " + dateTempEnd + "\r\n");
                foreach (var controlAZEL in datacontrol.control)
                {
                    text = text + ("มุม Azimuth : " + controlAZEL.azimuth + "\r\n");
                    text = text + ("มุม Elevation : " + controlAZEL.elevation + "\r\n");
                    text = text + "\r\n";
                    break;
                }


                if (round > 2)
                {
                    break;
                }
            }
            if (text.Length == 0)
            {
                text="ไม่มีเวลารับสัญญาณ";
            }
            if (e.Message.Type == Telegram.Bot.Types.Enums.MessageType.TextMessage)
            {
                if (e.Message.Text == "/เวลารับสัญญาณต่อไป")
                {
                    Bot.SendTextMessageAsync(e.Message.Chat.Id,text);
                }
               
            }
        }
        public class control
        {
            public String time { get; set; }
            public String azimuth { get; set; }
            public String elevation { get; set; }

        }
        public class getDataControlTime
        {
            public Object Id { get; set; }
            public String idControl { get; set; }
            public String namesatellite { get; set; }
            public String status { get; set; }
            public String timestart { get; set; }
            public String timestamp { get; set; }
            public String timestop { get; set; }
            public control[] control { get; set; }
            public DateTime updated_at { get; set; }
            public String Date { get; set; }
            public DateTime created_at { get; set; }

        }
    }
}
