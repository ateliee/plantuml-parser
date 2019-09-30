<?php
namespace Ateliee\Tests\Parser;

use Ateliee\PlantUMLParser\PUMLElementList;
use Ateliee\PlantUMLParser\PUMLParser;
use Ateliee\Tests\PUMLAssert;

class PUMLReadTest extends \PHPUnit_Framework_TestCase {

    /**
     * シーケンス図の正常系テスト
     *
     * @see http://plantuml.com/ja/sequence-diagram
     */
    public function testValidSequence()
    {
        PUMLAssert::assertEncodeDecode("@startuml
Alice -> Bob: Authentication Request
Bob --> Alice: Authentication Response

Alice -> Bob: Another authentication Request
Alice <-- Bob: another authentication Response
@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
actor Foo1
boundary Foo2
control Foo3
entity Foo4
database Foo5
collections Foo6
Foo1 -> Foo2 : To boundary
Foo1 -> Foo3 : To control
Foo1 -> Foo4 : To entity
Foo1 -> Foo5 : To database
Foo1 -> Foo6 : To collections

@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
actor Bob #red
' The only difference between actor
'and participant is the drawing
participant Alice
participant \"I have a really\nlong name\" as L #99FF99
/' You can also declare:
   participant L as \"I have a really\nlong name\"  #99FF99
  '/

Alice->Bob: Authentication Request
Bob->Alice: Authentication Response
Bob->L: Log transaction
@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
participant Last order 30
participant Middle order 20
participant First order 10
@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
Alice -> \"Bob()\" : Hello
\"Bob()\" -> \"This is very\nlong\" as Long
' You can also declare:
' \"Bob()\" -> Long as \"This is very\nlong\"
Long --> \"Bob()\" : ok
@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
Alice->Alice: This is a signal to self.\nIt also demonstrates\nmultiline \ntext
@enduml");

        PUMLAssert::assertEncodeDecode("@startuml
Bob ->x Alice
Bob -> Alice
Bob ->> Alice
Bob -\ Alice
Bob \\- Alice
Bob //-- Alice

Bob ->o Alice
Bob o\\-- Alice

Bob <-> Alice
Bob <->o Alice
@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
Bob -[#red]> Alice : hello
Alice -[#0000FF]->Bob : ok
@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
autonumber
Bob -> Alice : Authentication Request
Bob <- Alice : Authentication Response
@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
autonumber
Bob -> Alice : Authentication Request
Bob <- Alice : Authentication Response

autonumber 15
Bob -> Alice : Another authentication Request
Bob <- Alice : Another authentication Response

autonumber 40 10
Bob -> Alice : Yet another authentication Request
Bob <- Alice : Yet another authentication Response

@enduml");
        PUMLAssert::assertEncodeDecode("@startuml
autonumber \"<b>[000]\"
Bob -> Alice : Authentication Request
Bob <- Alice : Authentication Response

autonumber 15 \"<b>(<u>##</u>)\"
Bob -> Alice : Another authentication Request
Bob <- Alice : Another authentication Response

autonumber 40 10 \"<font color=red><b>Message 0  \"
Bob -> Alice : Yet another authentication Request
Bob <- Alice : Yet another authentication Response

@enduml");
    }
}