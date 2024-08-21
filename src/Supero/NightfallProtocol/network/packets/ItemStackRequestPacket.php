<?php

namespace Supero\NightfallProtocol\network\packets;

use pocketmine\network\mcpe\protocol\ItemStackRequestPacket as PM_Packet;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use Supero\NightfallProtocol\network\packets\types\inventory\CustomItemStackRequest;

class ItemStackRequestPacket extends PM_Packet {

    public array $requests;

    /**
     * @generate-create-func
     */
    public static function createPacket(array $requests) : self {
        $result = new self;
        $result->requests = $requests;
        return $result;
    }
    protected function decodePayload(PacketSerializer $in) : void {
        $this->requests = [];
        for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
            $this->requests[] = CustomItemStackRequest::read($in);
        }
    }
    protected function encodePayload(PacketSerializer $out) : void {
        $out->putUnsignedVarInt(count($this->requests));
        foreach($this->requests as $request){
            $request->write($out);
        }
    }
    public function getConstructorArguments(PM_Packet $packet): array {
        return [
            $packet->getRequests(),
        ];
    }
}