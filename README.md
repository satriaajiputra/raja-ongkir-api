<p align="center">
 <img src="http://satmaxt.xyz/theme/LikeEarth/assets/img/logo.png" width="170" />
</p>
# raja-ongkir-api
Raja Ongkir API Starter - API Starter untuk cek ongkos kirim, dan mendapatkan data provinsi beserta kota.

Daftar akun RajaOngkir [disini](http://rajaongkir.com/akun/daftar "RajaOngkir")

# Quick Setup
Contoh penggunaan simpel **raja-ongkir-api** untuk mendapatkan data seluruh provinsi di indonesia
```php
<?php

require_once 'src/rajaOngkir.php';

$init = new RajaOngkir('yourApiKey', true);
echo $init->getProvince();

```

Hasil dari script di atas adalah seperti ini
```json
[
	{
		"province_id": "1",
		"province": "Bali"
	},
	{
		"province_id": "2",
		"province": "Bangka Belitung"
	},
	{
		"province_id": "3",
		"province": "Banten"
	},
	{
		"province_id": "4",
		"province": "Bengkulu"
	},
	...
]
```

Jika ingin mendapatkan kode full atau tanpa di minimalize, cukup ganti ```true``` menjadi ```false``` pada saat inisiasi class.
Contoh full result seperti berikut
```json
{
	"rajaongkir": {
		"query": [],
		"status": {
			"code": 200,
			"description": "OK"
		},
		"results": [
			{
				"province_id": "1",
				"province": "Bali"
			},
			{
				"province_id": "2",
				"province": "Bangka Belitung"
			},
			{
				"province_id": "3",
				"province": "Banten"
			},
			...
		]
	}
}
```

# How to use it
Seperti biasa untuk memulai anda harus melakukan inisiasi terlebih dahulu terhadap class. Jika sudah berikut beberapa fungsi yang sudah tersedia.

* [Seluruh data provinsi](#seluruh-data-provinsi)
* [Provinsi dengan ID](#provinsi-dengan-id)
* [Seluruh data kota](#seluruh-data-kota)
* [Seluruh kota di provinsi](#seluruh-kota-di-provinsi)
* [Kota dengan ID](#kota-dengan-id)
* [Tracking harga](#tracking-harga)

## Seluruh data provinsi
```php
$init = new RajaOngkir('yourApiKey', true);
echo $init->getProvince();
```

## Provinsi dengan id
```php
$init = new RajaOngkir('yourApiKey', true);
echo $init->getProvince(9);
```

## Seluruh data kota
```php
$init = new RajaOngkir('yourApiKey', true);
echo $init->getCity();
```

## Kota dengan id
```php
$init = new RajaOngkir('yourApiKey', true);
echo $init->getCity(430, false);
```

## Seluruh kota di provinsi
```php
$init = new RajaOngkir('yourApiKey', true);
echo $init->getCity(false, 9);
```

## Tracking Harga
Parameter diisi dengan ```id kota sekarang``` - ```id kota tujuan``` - ```berat barang(gram)``` - ```courier```
Parameter bisa diganti dengan id provinsi.
Untuk courier bisa diisi dengan ```jne,pos,tiki```

```php
$init = new RajaOngkir('yourApiKey', true);
echo $init->getCost(from, to, weight, courier);
```
