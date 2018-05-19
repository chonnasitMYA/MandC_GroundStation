using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Net.Sockets;
using System.Net;
using System.IO;

namespace CTCP
{
    public partial class Form1 : Form
    {
        TcpClient client;
        NetworkStream clientStream;
        byte[] message = new byte[4096];

        public Form1()
        {
            InitializeComponent();
        }

        private void btConnect_Click(object sender, EventArgs e)
        {
            client = new TcpClient();
            IPEndPoint serverEndPoint = new IPEndPoint(IPAddress.Parse(tbServerHost.Text), int.Parse(tbPort.Text));
            client.Connect(serverEndPoint);

            clientStream = client.GetStream();
            StreamReader sr = new StreamReader(clientStream);
            String data = sr.ReadLine();
            addReceive(data+"\r\n");
            this.Text += " : "+data.Trim().Substring(data.Trim().Length-1);

            timer1.Start();
        }

        private void btSend_Click(object sender, EventArgs e)
        {
            if (tbSend.Text.Length > 0)
            {
                timer1.Stop();

                //clientStream = client.GetStream();

                //text style
                //write
                StreamWriter sw = new StreamWriter(clientStream);
                sw.WriteLine(tbSend.Text);
                sw.Flush();

                //read back
                StreamReader sr = new StreamReader(clientStream);
                try
                {
                    String s = sr.ReadLine();
                    addReceive(s + "\r\n");
                }
                catch { }

                //----------------

                //stream style
                //write
                ASCIIEncoding encoder = new ASCIIEncoding();                
                byte[] buffer = encoder.GetBytes(tbSend.Text+"\r\n");
                clientStream.Write(buffer, 0, buffer.Length);
                clientStream.Flush();

                //read back
                byte[] message = new byte[4096];
                int bytesRead;
                bytesRead = 0;
                try
                {
                    //blocks until a client sends a message
                    bytesRead = clientStream.Read(message, 0, 4096);
                    //message has successfully been received
                    ASCIIEncoding encoder2 = new ASCIIEncoding();
                    String txtdata = encoder2.GetString(message, 0, bytesRead);
                    addReceive(txtdata+"\r\n");
                }
                catch
                {
                    //a socket error has occured
                }

                timer1.Start();
            }
        }

        private void addReceive (String s)
        {
            tbReceive.Text += s.Trim()+"\r\n";
            tbReceive.SelectionStart = tbReceive.Text.Length;
            tbReceive.ScrollToCaret();
        }

        private void btClose_Click(object sender, EventArgs e)
        {
            client.Close();
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            //read back
            byte[] message = new byte[4096];
            int bytesRead;
            bytesRead = 0;
            clientStream.ReadTimeout = 90;
            try
            {
                //blocks until a client sends a message
                bytesRead = clientStream.Read(message, 0, 4096);
                //message has successfully been received
                ASCIIEncoding encoder2 = new ASCIIEncoding();
                String txtdata = encoder2.GetString(message, 0, bytesRead);
                addReceive(txtdata + "\r\n");
            }
            catch
            {
                //a socket error has occured
            }
            clientStream.ReadTimeout = -1;
        }
    }
}
