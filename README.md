# This is just a PHP sample

## PHP env settings

1.Downloads the `xampp` installer

2.If the surfix of the downloaded file is not `.dmg(for Mac OS)`, manually change it to.

3.Open up the `XAMPP`, go to `Volumes`, mount the folder.

4.Check the folder path, and using the cli below mount the folder locally

```bash
#/opt/lampp is the mounted path

sudo mkdir lampp
sudo mount -t nfs -o resvport,rw 192.168.64.2:/opt/lampp /opt/lampp
```

## Start Service on `localhost`

1. Following the steps above
2. Go to `Network` in `XAMPP` and enable the forwording rules
