
<?php


trait Hewan{
    public $namaHewan;
    public $aksi;
    public $attackPower;
    public $defencePower;

    public function atraksi(){
        echo "{$this->nama} sedang {$this->aksi}";
    }

}

trait Fight{
    use Hewan;
    public $nama;
    public $aksi;
    public $attackPower;
    public $defencePower;

public function serang($hewan){
    echo "{this->nama} serang {$hewan->namaHewan}";
}
public function diserang($hewan){
    echo "{this->nama} diserang {$hewan->namaHewan}";
}
}

class Harimau extends Fight
{
    public $kaki;
    public $atttackPower;
    public $differencePower;

}
class Singa extends Fight
{
    public $kaki;
    public $atttackPower;
    public $differencePower;
}

