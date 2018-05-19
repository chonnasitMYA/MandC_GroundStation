using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Net;
using System.Threading;
using System.Net.Sockets;
using System.Globalization;
using System.Threading.Tasks;
using MongoDB.Bson;
using MongoDB.Driver;
using MongoDB.Driver.Core;
using MongoDB.Driver.Linq;
using MongoDB.Bson.Serialization.Attributes;
using Telegram.Bot;
using System.IO;

namespace MTCP
{
    delegate void SetTextCallback(string text);
    delegate void SetInfoCallback(string text);

    public partial class Form1 : Form
    {
        private TcpListener tcpListener;
        private Thread listenThread;
        private int clientNo = 0; 

        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            tcpListener = new TcpListener(IPAddress.Any, 9090);
            try
            {
                listenThread = new Thread(new ThreadStart(ListenerThreadHandle));
                listenThread.Start();
                IPHostEntry IPHost = Dns.GetHostEntry(Dns.GetHostName());
                for (int i = 0; i < IPHost.AddressList.Length; ++i)
                    SetText("Server IP " + IPHost.AddressList[i].ToString() + " listen..");
            }
            catch (Exception ex)
            {
                Console.WriteLine("TCP Start exception has occurred!" + ex.ToString());
                listenThread.Abort();                    
            }
        }

        private void ListenerThreadHandle()
        {
            tcpListener.Start();
            while (true)
            {

                    TcpClient client = tcpListener.AcceptTcpClient();
                    //Socket clientsock = tcpListener.AcceptSocket();


                    SetText("Clinet " + clientNo + " connected!!");
                                     
                    Global.setTcpClient(clientNo, client);
                    //Global.setTcpClientSocket(clientNo, clientsock);

                    Thread clientThread = new Thread(new ParameterizedThreadStart(ClientThreadHandle));
                    clientThread.Start(clientNo++);
                    Global.setClientCount(clientNo);
                    SetInfo("Client Amount :" + Global.getClientCount());
                
            }
        }

        private void ClientThreadHandle(object clientNo)
        {

            while (true)
            {
                try
                {
                    var conString = "mongodb://localhost:27017";
                    var Client = new MongoClient(conString);
                    var DB = Client.GetDatabase("SatelliteDB");
                    var collectionControlTime = DB.GetCollection<getDataControlTime>("ControlTime");
                    var data = collectionControlTime.AsQueryable<getDataControlTime>().ToList();
                    var controlAZEL = (data[0].control).AsQueryable<control>().ToArray();
                    var startdate = data[0].timestart;
                    var enddate = data[0].timestop;
                    DateTime startdate2 = DateTime.ParseExact(startdate, "M/d/yyyy h:mm:ss tt", CultureInfo.InvariantCulture);
                    Console.WriteLine("startdate2 = " + startdate2);
                    var Datetemp = DateTime.Now.ToString("M/d/yyyy h:mm:ss tt", new CultureInfo("en-US"));
                    DateTime localDate = DateTime.ParseExact(Datetemp, "M/d/yyyy h:mm:ss tt", CultureInfo.InvariantCulture);

                    long checkStart = ((DateTimeOffset)startdate2).ToUnixTimeSeconds();
                    long checkLocalDate = ((DateTimeOffset)localDate).ToUnixTimeSeconds();
                    Console.WriteLine("checkStart = " + checkStart);
                    Console.WriteLine("checkLocalDate = " + checkLocalDate);
                    Console.WriteLine("operater = " + (checkStart - checkLocalDate)); // ได้ผลลัพท์เป็นวิ
                    if ((checkStart - checkLocalDate) < 0)
                    {

                        int myID = (int)clientNo;
                        byte[] message = new byte[4096];
                        String txtmsg = "";
                        String txtresult = "";
                        TcpClient tcpClient = Global.getTcpClient(myID);
                        NetworkStream clientStream = tcpClient.GetStream();
                        conString = "mongodb://localhost:27017";
                        Client = new MongoClient(conString);
                        DB = Client.GetDatabase("SatelliteDB");
                        var collectionconfigAZEL = DB.GetCollection<getAzEl>("configAZEL");
                        var dataAZEL = collectionconfigAZEL.AsQueryable<getAzEl>().ToArray();
                        String AZ = dataAZEL[0].azimuth;
                        String El = dataAZEL[0].elevation;
                        int bytesRead = 0;

                        try
                        {
                            //blocks until a client sends a message
                            bytesRead = clientStream.Read(message, 0, 4096);
                            //bytesRead = ssock.Receive(message, message.Length, 0);
                        }
                        catch
                        {
                            //a socket error has occured
                            break;
                        }

                        if (bytesRead == 0)
                        {
                            //the client has disconnected from the server
                            break;
                        }
                        String hello = "AZ=" + AZ + "," + "EL=" + El + "\r\n";
                        SetText(hello);
                        byte[] helloByte = Encoding.ASCII.GetBytes(hello);
                        clientStream.Write(helloByte, 0, hello.Length);
                        //message has successfully been received
                        ASCIIEncoding encoder = new ASCIIEncoding();
                        String txtdata = encoder.GetString(message, 0, bytesRead);
                        SetText("String :" + txtdata);
                        /*             if (txtdata.Contains('\r') || txtdata.Contains('\n'))
                                       {
                                           int pos, pos2;
                                           if (txtdata.Contains('\r'))
                                           {
                                               //end with \r, windows style
                                               pos = txtdata.IndexOf('\r');
                                           }
                                           else
                                           {
                                               //end with \n, unix style
                                               pos = txtdata.IndexOf('\n');
                                           }
                                           txtmsg += txtdata.Substring(0, pos); */
                        txtmsg = txtdata;
                        txtresult = txtmsg;
                        /*                   pos = txtdata.IndexOf("\r\n");
                                           pos2 = txtdata.IndexOf("\n\n");
                                           if (pos >= 0 || pos2 > 0) pos = pos + 1;
                                           txtmsg = txtdata.Substring(pos + 1);*/
                        SetText("Result String :" + txtresult);
                        //if (txtresult == "#exit") finished = true;

                        //forward to all
                        SendAllClient(myID + ":" + txtresult);
                    }
                    else if ((checkStart - checkLocalDate) < 60 * 3) //เช็คว่าเกิน 3 นาทีไหม
                    {
                        var text = "เหลือเวลาอีก 3 นาทีจะถึงเวลารับสัญญาณดาวเทียม " + (data[0].namesatellite);
                        var bot = new Telegram.Bot.TelegramBotClient("572794128:AAGve89M6IRZc3-H5fBWgU66lMTFuPxg49c");
                        bot.SendTextMessageAsync(-272664117, text);
                        var requestLine = (HttpWebRequest)WebRequest.Create("https://notify-api.line.me/api/notify");
                        var postDataLine = string.Format("message={0}", text);
                        var dataLine = Encoding.UTF8.GetBytes(postDataLine);

                        requestLine.Method = "POST";
                        requestLine.ContentType = "application/x-www-form-urlencoded";
                        requestLine.ContentLength = dataLine.Length;
                        requestLine.Headers.Add("Authorization", "Bearer 7NobgAnQVINIPDXBDpfKqs8JOP4nO07vu6VJ3OfSuyh");

                        using (var stream = requestLine.GetRequestStream())
                        {
                            stream.Write(dataLine, 0, dataLine.Length);
                        }

                        var responseline = (HttpWebResponse)requestLine.GetResponse();
                        var responseStringline = new StreamReader(responseline.GetResponseStream()).ReadToEnd();

                        int myID = (int)clientNo;
                        TcpClient tcpClient = Global.getTcpClient(myID);
                        NetworkStream clientStream = tcpClient.GetStream();
                        conString = "mongodb://localhost:27017";
                        Client = new MongoClient(conString);
                        DB = Client.GetDatabase("SatelliteDB");
                        collectionControlTime = DB.GetCollection<getDataControlTime>("ControlTime");

                        data = collectionControlTime.AsQueryable<getDataControlTime>().ToList();
                        controlAZEL = (data[0].control).AsQueryable<control>().ToArray();

                        //send hello first

                        /*            String hello = "AZ=" + AZ + "EL=" + El +"\r\n";
                                    byte[] helloByte = Encoding.ASCII.GetBytes(hello);
                                    clientStream.Write(helloByte, 0, hello.Length);*/
                        //ssock.Send(helloByte, hello.Length, SocketFlags.None);

                        byte[] message = new byte[4096];
                        String txtmsg = "";
                        String txtresult = "";
                        int bytesRead;
                        //bool finished = false;
                        startdate = data[0].timestart;
                        enddate = data[0].timestop;
                        Console.WriteLine("startdate = " + startdate);
                        Console.WriteLine("enddate = " + enddate);
                        // DateTime localDate = DateTime.Now.ToString("yyyy-MM-dd HH:mm:sszzz"); 
                        startdate2 = DateTime.ParseExact(startdate, "M/d/yyyy h:mm:ss tt", CultureInfo.InvariantCulture);
                        DateTime enddate2 = DateTime.ParseExact(enddate, "M/d/yyyy h:mm:ss tt", CultureInfo.InvariantCulture);
                        // DateTime localDate = DateTime.Now.ToString("yyyy-MM-dd HH:mm:sszzz"); 
                        Datetemp = DateTime.Now.ToString("M/d/yyyy h:mm:ss tt", new CultureInfo("en-US"));

                        //Console.WriteLine("typeof : " + startdate2.GetType());
                        localDate = DateTime.ParseExact(Datetemp, "M/d/yyyy h:mm:ss tt", CultureInfo.InvariantCulture);

                        /* Console.WriteLine("typeof : " + startdate2.GetType());
                         Console.WriteLine("typeof : " + localDate.GetType());
                         */
                        var i = 0;
                        while (localDate <= enddate2)
                        {
                            int total = 0;
                            if (startdate2.Minute > localDate.Minute && startdate2.Second > localDate.Second)
                            {
                                total = 60 * (60 - startdate2.Minute + localDate.Minute) + (localDate.Second + (60 - startdate2.Second));
                            }
                            else if (startdate2.Minute > localDate.Minute)
                            {
                                total = 60 * (60 - startdate2.Minute + localDate.Minute) + (localDate.Second - startdate2.Second);
                            }
                            /*else if (startdate2.Second > localDate.Second)
                            {
                                total = 60 * (localDate.Minute - startdate2.Minute) + (localDate.Second + (60 - startdate2.Second));
                            }*/
                            else
                            {
                                total = 60 * (localDate.Minute - startdate2.Minute) + (localDate.Second - startdate2.Second);
                            }
                            SetText(total.ToString());
                            if (localDate >= startdate2)
                            {
                                bytesRead = 0;

                                try
                                {
                                    //blocks until a client sends a message
                                    bytesRead = clientStream.Read(message, 0, 4096);
                                    //bytesRead = ssock.Receive(message, message.Length, 0);
                                }
                                catch
                                {
                                    //a socket error has occured
                                    break;
                                }

                                if (bytesRead == 0)
                                {
                                    //the client has disconnected from the server
                                    break;
                                }
                                String AZ = controlAZEL[total].azimuth;
                                String El = controlAZEL[total].elevation;
                                String hello = Datetemp + "AZ=" + AZ + "," + "EL=" + El + "\r\n";
                                byte[] helloByte = Encoding.ASCII.GetBytes(hello);
                                clientStream.Write(helloByte, 0, hello.Length);
                                //message has successfully been received
                                ASCIIEncoding encoder = new ASCIIEncoding();
                                String txtdata = encoder.GetString(message, 0, bytesRead);
                                SetText("String :" + txtdata);
                                /*             if (txtdata.Contains('\r') || txtdata.Contains('\n'))
                                               {
                                                   int pos, pos2;
                                                   if (txtdata.Contains('\r'))
                                                   {
                                                       //end with \r, windows style
                                                       pos = txtdata.IndexOf('\r');
                                                   }
                                                   else
                                                   {
                                                       //end with \n, unix style
                                                       pos = txtdata.IndexOf('\n');
                                                   }
                                                   txtmsg += txtdata.Substring(0, pos); */
                                txtmsg = txtdata;
                                txtresult = txtmsg;
                                /*                   pos = txtdata.IndexOf("\r\n");
                                                   pos2 = txtdata.IndexOf("\n\n");
                                                   if (pos >= 0 || pos2 > 0) pos = pos + 1;
                                                   txtmsg = txtdata.Substring(pos + 1);*/
                                SetText("Result String :" + txtresult);

                                //if (txtresult == "#exit") finished = true;

                                //forward to all
                                SendAllClient(myID + ":" + txtresult);
                                //SetText("Total:" + txtresult);
                                //SetText("Total:" + txtresult.Length);
                                int j = 0;
                                int jj = 1;
                                int jjj = 2;
                                String az_str = "";
                                String el_str = "";
                                SetText("Total:"+txtresult);
                                //SetText("Total:" + txtresult.Length);
                                while (j < txtresult.Length)
                                {
                                    
                                    char c1 = txtresult[j];
                                    char c2 = txtresult[jj];
                                    char c3 = txtresult[jjj];
                                    if (c1 == 'A')
                                    {
                                        if (c2 == 'Z')
                                        {
                                            if (c3 == '=')
                                            {
                                                int ii = j + 2;
                                                while (true)
                                                {
                                                    if (txtresult[ii + 1] == ',')
                                                    {
                                                        j = ii;
                                                        SetText("AZZ=" + az_str);
                                                        //SetText("ELL=" + el_str);
                                                        break;
                                                        
                                                    }
                                                    ii = ii + 1;
                                                    az_str = az_str + txtresult[ii];
                                                }
                                            }
                                        }
                                    }
                                    if (c1 == 'E')
                                    {
                                        jj = j + 1;
                                        jjj = j + 2;
                                        c2 = txtresult[jj];
                                        c3 = txtresult[jjj];
                                        if (c2 == 'L')
                                        {
                                            if (c3 == '=')
                                            {
                                                int ii = j + 3;
                                                while (ii < txtresult.Length)
                                                {

                                                    j = ii;
                                                    el_str = el_str + txtresult[ii];
                                                    ii = ii + 1;
                                                    
                                                }
                                            }
                                        }

                                    }
                                    SetText("ELL=" + el_str);
                                    j = j + 1;
                                }
                                
                                var collectionconfigAZEL = DB.GetCollection<getAzEl>("configAZEL");
                                var data1 = collectionconfigAZEL.AsQueryable<getAzEl>().ToArray();
                                var builder2 = Builders<getAzEl>.Filter;
                                var filter2 = builder2.Eq("_id", data1[0].Id);
                                var updateAZ = Builders<getAzEl>.Update
                                    .Set("azimuth", az_str);
                                collectionconfigAZEL.UpdateOne(filter2, updateAZ, new UpdateOptions() { IsUpsert = true });

                                var updateEL = Builders<getAzEl>.Update
                                  .Set("elevation", el_str);
                                collectionconfigAZEL.UpdateOne(filter2, updateEL, new UpdateOptions() { IsUpsert = true });
                                //System.Threading.Thread.Sleep(1000);*
                                i = i + 1;
                            }
                            else
                            {

                                bytesRead = 0;

                                try
                                {
                                    //blocks until a client sends a message
                                    bytesRead = clientStream.Read(message, 0, 4096);
                                    //bytesRead = ssock.Receive(message, message.Length, 0);
                                }
                                catch
                                {
                                    //a socket error has occured
                                    break;
                                }

                                if (bytesRead == 0)
                                {
                                    //the client has disconnected from the server
                                    break;
                                }
                                String AZ = controlAZEL[0].azimuth;
                                String El = controlAZEL[0].elevation;
                                String hello = Datetemp + "AZ=" + AZ + "," + "EL=" + El + "\r\n";
                                byte[] helloByte = Encoding.ASCII.GetBytes(hello);
                                clientStream.Write(helloByte, 0, hello.Length);
                                //message has successfully been received
                                ASCIIEncoding encoder = new ASCIIEncoding();
                                String txtdata = encoder.GetString(message, 0, bytesRead);
                                SetText("String :" + txtdata);
                                /*             if (txtdata.Contains('\r') || txtdata.Contains('\n'))
                                               {
                                                   int pos, pos2;
                                                   if (txtdata.Contains('\r'))
                                                   {
                                                       //end with \r, windows style
                                                       pos = txtdata.IndexOf('\r');
                                                   }
                                                   else
                                                   {
                                                       //end with \n, unix style
                                                       pos = txtdata.IndexOf('\n');
                                                   }
                                                   txtmsg += txtdata.Substring(0, pos); */
                                txtmsg = txtdata;
                                txtresult = txtmsg;
                                /*                   pos = txtdata.IndexOf("\r\n");
                                                   pos2 = txtdata.IndexOf("\n\n");
                                                   if (pos >= 0 || pos2 > 0) pos = pos + 1;
                                                   txtmsg = txtdata.Substring(pos + 1);*/
                                SetText("Result String :" + txtresult);
                                //if (txtresult == "#exit") finished = true;

                                //forward to all
                                SendAllClient(myID + ":" + txtresult);

                                /*                }
                                                else
                                                {
                                                    txtmsg += txtdata;                    
                                                }*/
                                //System.Threading.Thread.Sleep(1000);

                            }
                            Datetemp = DateTime.Now.ToString("M/d/yyyy h:mm:ss tt", new CultureInfo("en-US"));
                            localDate = DateTime.ParseExact(Datetemp, "M/d/yyyy h:mm:ss tt", CultureInfo.InvariantCulture);
                        }
                        var collectioncontrol = DB.GetCollection<getDatacontrol>("control");

                        var tempProperty = "Y";
                        var builder = Builders<getDatacontrol>.Filter;
                        var filter = builder.Eq("_id", ObjectId.Parse(data[0].idControl));
                        //Console.WriteLine("AZ = " + filter);
                        var update = Builders<getDatacontrol>.Update
                            .Set("status", tempProperty);
                        collectioncontrol.UpdateOne(filter, update, new UpdateOptions() { IsUpsert = true });

                        collectionControlTime.DeleteOne(a => a.Id == data[0].Id);
                        //Console.WriteLine("Helllo");
                        //Console.ReadKey();
                        //form reply answer
                        /*try
                        {
                            String myAnswerStr = "bye\r\n";
                            byte[] myAnswer = Encoding.ASCII.GetBytes(myAnswerStr);
                            clientStream.Write(myAnswer, 0, myAnswerStr.Length);
                            //ssock.Send(myAnswer, myAnswer.Length, SocketFlags.None);
                        }
                        catch (Exception e)
                        {
                            MessageBox.Show(e.ToString());
                        }*/

                        //tcpClient.Close();
                        //ssock.Close();
                        //SetText("Client " + myID + " closed!!");
                    }
                    else
                    {
                        int myID = (int)clientNo;
                        byte[] message = new byte[4096];
                        String txtmsg = "";
                        String txtresult = "";
                        TcpClient tcpClient = Global.getTcpClient(myID);
                        NetworkStream clientStream = tcpClient.GetStream();
                        conString = "mongodb://localhost:27017";
                        Client = new MongoClient(conString);
                        DB = Client.GetDatabase("SatelliteDB");
                        var collectionconfigAZEL = DB.GetCollection<getAzEl>("configAZEL");
                        var dataAZEL = collectionconfigAZEL.AsQueryable<getAzEl>().ToArray();
                        String AZ = dataAZEL[0].azimuth;
                        String El = dataAZEL[0].elevation;
                        int bytesRead = 0;

                        try
                        {
                            //blocks until a client sends a message
                            bytesRead = clientStream.Read(message, 0, 4096);
                            //bytesRead = ssock.Receive(message, message.Length, 0);
                        }
                        catch
                        {
                            //a socket error has occured
                            break;
                        }

                        if (bytesRead == 0)
                        {
                            //the client has disconnected from the server
                            break;
                        }
                        String hello = "AZ=" + AZ + "," + "EL=" + El + "\r\n";
                        byte[] helloByte = Encoding.ASCII.GetBytes(hello);
                        clientStream.Write(helloByte, 0, hello.Length);
                        //message has successfully been received
                        ASCIIEncoding encoder = new ASCIIEncoding();
                        String txtdata = encoder.GetString(message, 0, bytesRead);
                        SetText("String :" + txtdata);
                        /*             if (txtdata.Contains('\r') || txtdata.Contains('\n'))
                                       {
                                           int pos, pos2;
                                           if (txtdata.Contains('\r'))
                                           {
                                               //end with \r, windows style
                                               pos = txtdata.IndexOf('\r');
                                           }
                                           else
                                           {
                                               //end with \n, unix style
                                               pos = txtdata.IndexOf('\n');
                                           }
                                           txtmsg += txtdata.Substring(0, pos); */
                        txtmsg = txtdata;
                        txtresult = txtmsg;
                        /*                   pos = txtdata.IndexOf("\r\n");
                                           pos2 = txtdata.IndexOf("\n\n");
                                           if (pos >= 0 || pos2 > 0) pos = pos + 1;
                                           txtmsg = txtdata.Substring(pos + 1);*/
                        SetText("Result String :" + txtresult);
                        //if (txtresult == "#exit") finished = true;

                        //forward to all
                        SendAllClient(myID + ":" + txtresult);
                    }

                }
                catch (Exception)
                {

                    int myID = (int)clientNo;
                    byte[] message = new byte[4096];
                    String txtmsg = "";
                    String txtresult = "";
                    TcpClient tcpClient = Global.getTcpClient(myID);
                    NetworkStream clientStream1 = tcpClient.GetStream();
                    var conString = "mongodb://localhost:27017";
                    var Client = new MongoClient(conString);
                    var DB = Client.GetDatabase("SatelliteDB");
                    var collectionconfigAZEL = DB.GetCollection<getAzEl>("configAZEL");
                    var dataAZEL = collectionconfigAZEL.AsQueryable<getAzEl>.ToArray();
                    String AZ = dataAZEL[0].azimuth;
                    String El = dataAZEL[0].elevation;
                    int bytesRead = 0;

                    try
                    {
                        //blocks until a client sends a message
                        bytesRead = clientStream1.Read(message, 0, 4096);
                        //bytesRead = ssock.Receive(message, message.Length, 0);
                    }
                    catch
                    {
                        //a socket error has occured
                        break;
                    }

                    if (bytesRead == 0)
                    {
                        //the client has disconnected from the server
                        break;
                    }
                    String hello = "AZ=" + AZ + "," + "EL=" + El + "\r\n";
                    SetText(hello);
                    byte[] helloByte = Encoding.ASCII.GetBytes(hello);
                    clientStream1.Write(helloByte, 0, hello.Length);
                    //message has successfully been received
                    ASCIIEncoding encoder = new ASCIIEncoding();
                    String txtdata = encoder.GetString(message, 0, bytesRead);
                    SetText("String :" + txtdata);

                    txtmsg = txtdata;
                    txtresult = txtmsg;

                    SetText("Result String :" + txtresult);
                    //if (txtresult == "#exit") finished = true;

                    //forward to all
                    SendAllClient(myID + ":" + txtresult);
                }




            }


        }

        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            Global.setExit();
            SetText("Mark exit listener thread");
            btQuit_Click(sender, e);
        }

        private void btQuit_Click(object sender, EventArgs e)
        {
            Global.setExit();
            listenThread.Abort();
            Application.ExitThread();
            Application.Exit();
            Environment.Exit(0);
            this.Close();
        }

        private void SetText(string text)
        {
            // InvokeRequired required compares the thread ID of the
            // calling thread to the thread ID of the creating thread.
            // If these threads are different, it returns true.
            if (this.lbConnections.InvokeRequired)
            {
                SetTextCallback d = new SetTextCallback(SetText);
                this.Invoke(d, new object[] { text });
            }
            else
            {
                this.lbConnections.Items.Add(text);
                //auto scroll
                this.lbConnections.SelectedIndex = this.lbConnections.Items.Count - 1;
                this.lbConnections.SelectedIndex = -1;
            }
        }

        private void SetInfo(string text)
        {
            if (this.lbInfo.InvokeRequired)
            {
                try
                {
                    SetInfoCallback d = new SetInfoCallback(SetInfo);
                    this.Invoke(d, new object[] { text });
                }
                catch (ObjectDisposedException oe)
                {
                    MessageBox.Show(oe.ToString());
                }
            }
            else
            {
                if (text.Contains("Client Amount")) this.lbInfo.Items.Clear();
                this.lbInfo.Items.Add(text);
                this.lbInfo.Items.Add("");
                for (int i = 0; i < Global.getClientCount(); ++i)
                {
                    this.lbInfo.Items.Add((i+1)+": "+Global.getTcpClient(i).Client.RemoteEndPoint.ToString());
                }
            }
        }

        private void btSend_Click(object sender, EventArgs e)
        {
            SendAllClient(tbSend.Text+"\r\n");
        }

        private void SendAllClient(String str)
        {
            NetworkStream clientStream;
            str = str.Trim();
            str += "\r\n";

            for (int i = 0; i < Global.getClientCount(); ++i)
            {
                try
                {

                    //form reply answer for all
                    byte[] myForward = Encoding.ASCII.GetBytes(str);
                    clientStream = Global.getTcpClient(i).GetStream();
                    clientStream.Write(myForward, 0, str.Length);
                    //Global.getTcpClientSocket(i).Send(myForward, myForward.Length, 0);
                }
                catch (Exception oe) {
                    //MessageBox.Show(oe.ToString());
                    Console.WriteLine(oe.ToString());
                }
            }
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
        public class control
        {
            public String time { get; set; }
            public String azimuth { get; set; }
            public String elevation { get; set; }

        }

        public class getDatacontrol
        {
            public Object Id { get; set; }
            public String namesatellite { get; set; }
            public String status { get; set; }
            public String timestart { get; set; }
            public String timestamp { get; set; }
            public String timestop { get; set; }
            public String Date { get; set; }
            public control[] control { get; set; }
            public DateTime updated_at { get; set; }
            public DateTime created_at { get; set; }

        }
        public class getAzEl
        {
            public Object Id { get; set; }
            public String azimuth { get; set; }
            public String elevation { get; set; }
            public String timestamp { get; set; }
            public DateTime updated_at { get; set; }
            public DateTime created_at { get; set; }

        }

    }
}
