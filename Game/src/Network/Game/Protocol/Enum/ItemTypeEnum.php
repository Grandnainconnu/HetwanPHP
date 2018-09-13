<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-30 15:37:24
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 16:18:17
 */

namespace Hetwan\Network\Game\Protocol\Enum;


class ItemTypeEnum extends AbstractEnum
{
	const AMULET = 1;
	const BOW = 2;
	const WAND = 3;
	const STAFF = 4;
	const DAGGER = 5;
	const SWORD = 6;
	const HAMMER = 7;
	const SHOVEL = 8;
	const RING = 9;
	const BELT = 10;
	const BOOT = 11;
	const POTION = 12;
	const EXPERIENCEPARCHMENT = 13;
	const GIFT = 14;
	const RESOURCE = 15;
	const HAT = 16;
	const CLOAK = 17;
	const PET = 18;
	const AXE = 19;
	const TOOL = 20;
	const PICKAXE = 21;
	const SCYTHE = 22;
	const DOFUS = 23;
	const QUEST = 24;
	const DOCUMENT = 25;
	const ALCHEMYPOTION = 26;
	const TRANSFORM = 27;
	const BOOSTFOOD = 28;
	const BENEDICTION = 29;
	const MALEDICTION = 30;
	const ROLEPLAYGIFT = 31;
	const FOLLOWER = 32;
	const BREAD = 33;
	const CEREAL = 34;
	const FLOWER = 35;
	const PLANT = 36;
	const BEER = 37;
	const WOOD = 38;
	const ORE = 39;
	const ALLOY = 40;
	const FISH = 41;
	const CANDY = 42;
	const FORGETPOTION = 43;
	const JOBPOTION = 44;
	const SPELLPOTION = 45;
	const FRUIT = 46;
	const BONE = 47;
	const POWDER = 48;
	const COMESTIBLEFISH = 49;
	const PRECIOUSSTONE = 50;
	const STONE = 51;
	const FLOUR = 52;
	const FEATHER = 53;
	const HAIR = 54;
	const FABRIC = 55;
	const LEATHER = 56;
	const WOOL = 57;
	const SEED = 58;
	const SKIN = 59;
	const OIL = 60;
	const STUFFEDTOY = 61;
	const GUTTEDFISH = 62;
	const MEAT = 63;
	const PRESERVEDMEAT = 64;
	const TAIL = 65;
	const METARIA = 66;
	const VEGETABLE = 68;
	const COMESTIBLEMEAT = 69;
	const DYE = 70;
	const ALCHEMYEQUIPMENT = 71;
	const PETEGG = 72;
	const WEAPONCONTROL = 73;
	const FEEARTIFICE = 74;
	const SPELLPARCHMENT = 75;
	const STATPARCHMENT = 76;
	const KENNELCERTIFICATE = 77;
	const SMITHMAGICRUNE = 78;
	const DRINK = 79;
	const QUESTOBJECT = 80;
	const BACKPACK = 81;
	const SHIELD = 82;
	const SOULSTONE = 83;
	const KEY = 84;
	const FULLSOULSTONE = 85;
	const PERCEPTEURFORGETPOTION = 86;
	const PARCHO_RECHERCHE = 87;
	const MAGICSTONE = 88;
	const GIFTS = 89;
	const GHOSTPET = 90;
	const DRAGODINDE = 91;
	const BOUFTOU = 92;
	const BREEDINGOBJECT = 93;
	const USABLEOBJECT = 94;
	const PLANK = 95;
	const BARK = 96;
	const DRAGODINDECERTIFICATE = 97;
	const ROOT = 98;
	const CATCHNET = 99;
	const RESOURCEBAG = 100;
	const CROSSBOW = 102;
	const PAW = 103;
	const WING = 104;
	const EGG = 105;
	const EAR = 106;
	const CARAPACE = 107;
	const BUD = 108;
	const EYE = 109;
	const JELLY = 110;
	const SHELL = 111;
	const PRISM = 112;
	const OBVIJEVAN = 113;
	const MAGICWEAPON = 114;
	const SHUSHUSOULPIECE = 115;
	const PETPOTION = 116;

	public static function isEquipement(int $type)
	{
		return (
			$type == ItemTypeEnum::AMULET ||
			$type == ItemTypeEnum::RING ||
			$type == ItemTypeEnum::BELT ||
			$type == ItemTypeEnum::BOOT ||
			$type == ItemTypeEnum::HAT ||
			$type == ItemTypeEnum::CLOAK ||
			$type == ItemTypeEnum::PET ||
			$type == ItemTypeEnum::DOFUS ||
			$type == ItemTypeEnum::BACKPACK ||
			$type == ItemTypeEnum::SHIELD ||
			$type == ItemTypeEnum::DRAGODINDE ||
			$type == ItemTypeEnum::OBVIJEVAN || 
			ItemTypeEnum::isWeapon($type)
		);
	}

	public static function isWeapon(int $type)
	{
		return (
			$type == ItemTypeEnum::BOW ||
			$type == ItemTypeEnum::WAND ||
			$type == ItemTypeEnum::STAFF ||
			$type == ItemTypeEnum::DAGGER ||
			$type == ItemTypeEnum::SWORD ||
			$type == ItemTypeEnum::HAMMER ||
			$type == ItemTypeEnum::SHOVEL ||
			$type == ItemTypeEnum::AXE ||
			$type == ItemTypeEnum::TOOL ||
			$type == ItemTypeEnum::PICKAXE ||
			$type == ItemTypeEnum::SCYTHE ||
			$type == ItemTypeEnum::CROSSBOW ||
			$type == ItemTypeEnum::SOULSTONE ||
			$type == ItemTypeEnum::MAGICWEAPON
		);
	}

	public static function isUsable(int $type)
	{
		return (
			$type == ItemTypeEnum::POTION ||
			$type == ItemTypeEnum::GIFT ||
			$type == ItemTypeEnum::BOOSTFOOD ||
			$type == ItemTypeEnum::BENEDICTION ||
			$type == ItemTypeEnum::MALEDICTION ||
			$type == ItemTypeEnum::BREAD ||
			$type == ItemTypeEnum::BEER ||
			$type == ItemTypeEnum::CANDY ||
			$type == ItemTypeEnum::FORGETPOTION ||
			$type == ItemTypeEnum::JOBPOTION ||
			$type == ItemTypeEnum::SPELLPOTION ||
			$type == ItemTypeEnum::GUTTEDFISH ||
			$type == ItemTypeEnum::MEAT ||
			$type == ItemTypeEnum::PRESERVEDMEAT ||
			$type == ItemTypeEnum::COMESTIBLEMEAT ||
			$type == ItemTypeEnum::WEAPONCONTROL ||
			$type == ItemTypeEnum::FEEARTIFICE ||
			$type == ItemTypeEnum::SPELLPARCHMENT ||
			$type == ItemTypeEnum::DRINK ||
			$type == ItemTypeEnum::FULLSOULSTONE ||
			$type == ItemTypeEnum::GIFTS ||
			$type == ItemTypeEnum::USABLEOBJECT ||
			$type == ItemTypeEnum::CATCHNET ||
			$type == ItemTypeEnum::PRISM ||
			$type == ItemTypeEnum::PETPOTION
		);
	}

	public static function isResource($type)
	{
		return (!ItemTypeEnum::isEquipement($type) || !ItemTypeEnum::isUsable($type));
	}
}