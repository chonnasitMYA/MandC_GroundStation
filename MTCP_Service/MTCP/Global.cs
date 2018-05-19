using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net.Sockets;

namespace MTCP
{
    public static class Global
    {
        public static TcpClient[] slave = new TcpClient[8];
        public static Socket[] slavesocket = new Socket[8];
        public static bool closeProg = false;
        public static int clientCount = 0;

        public static TcpClient getTcpClient(int n)
        {
            return slave[n];
        }

        public static void setTcpClient(int n, TcpClient s)
        {
            slave[n] = s;
        }

        public static Socket getTcpClientSocket(int n)
        {
            return slavesocket[n];
        }

        public static void setTcpClientSocket(int n, Socket s)
        {
            slavesocket[n] = s;
        }

        public static bool isExit()
        {
            return closeProg;
        }

        public static void setExit()
        {
            closeProg = true;
        }

        public static void setClientCount(int n)
        {
            clientCount = n;
        }

        public static int getClientCount()
        {
            return clientCount;
        }
    }
}
