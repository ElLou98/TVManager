use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\WebSocket\WsServer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use React\EventLoop\Factory;
use React\Socket\Server;

class WebSocketController extends AbstractController implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function index()
    {
        return new Response('WebSocket Server is running');
    }

    public function send()
    {
        $loop   = Factory::create();
        $socket = new Server('0.0.0.0:8080', $loop);

        $server = new IoServer(
            new HttpServer(
                new WsServer(
                    $this
                )
            ),
            $socket,
            $loop
        );

        $server->run();

        return new Response('Message sent to all connected clients');
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->clients as $client) {
            $client->send('Static message from URL: ' . $msg);
        }
    }
}
