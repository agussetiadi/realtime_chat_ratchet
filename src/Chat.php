<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $open_client;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later

        $this->clients->attach($conn);

        $this->open_client = $conn->resourceId;

        echo "New connection! ({$conn->resourceId})\n";

    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        

                $json_msg   = json_decode($msg);
                $app        = $json_msg->app;

            /*
            menerima data dari file JSON yang dikirim client
            */
            if ($app == "chat") {

                $user_id        = $json_msg->user_id;
                $message        = $json_msg->message;
                $msg_session    = $json_msg->msg_session;
                $result         = $user_id." : ".$message;

                $db = new \mysqli("localhost","root","","db_chat");
                $query = $db->query("SELECT * FROM message_session INNER JOIN user ON message_session.user_id = user.user_id WHERE message_session.message_session_id = $msg_session");


                /*$query2 = $db->query("INSERT INTO message_storage (message_session_id,user_id,message_value) VALUES('$msg_session','$user_id','$message')");*/


                while($fetch = $query->fetch_array()) {
                    $active_conn = $fetch['active_conn'];
                    $active_chat = $fetch['active_chat'];
                    $status = $fetch['status'];
                    foreach ($this->clients as $client) {
                        if ($active_conn == $client->resourceId && $status == "online" && $active_chat == $msg_session) {
                            $client->send($result);
                        }
                    }
                }
            }

            elseif ($app == "open_client") {
                $user_session = $json_msg->user_session;
                $port_client = $this->open_client;
                $db = new \mysqli("localhost","root","","db_chat");
                $query = $db->query("UPDATE user SET status = 'online', active_conn = $port_client WHERE user_id = $user_session");
            }





/*        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($result);
            }
        }*/
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages

        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";

        $last_seen = time();
        $db = new \mysqli("localhost","root","","db_chat");
        $query = $db->query("UPDATE user SET status = 'offline', last_seen =  WHERE active_conn = $conn->resourceId");
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}