INSERT INTO `pictures`(`id`, `url`, `main_url`, `tiny_url`, `filename`, `show_filename`, `comment`, `exif`, `size`, `width`, `height`, `guest_key`, `user_id`, `added`, `tag_id`, `access`, `rating`, `views`, `album_id`, `torrent_id`, `position`, `cover`, `old_image_id`) 
SELECT null,i.url,i.main_url,i.tiny_url,i.filename,i.show_filename,i.comment,i.exif, i.size,i.width,i.height,i.guest_key,null AS user_id,i.added,i.tag_id,i.access,i.rating,i.views, null AS album_id, i.torrent_id, i.position, i.cover, i.id FROM images_guests i  UNION 
SELECT null,i.url,i.main_url,i.tiny_url,i.filename,i.show_filename,i.comment,i.exif,i.size,i.width,i.height,null AS guest_key, i.user_id,i.added,i.tag_id,i.access,i.rating,i.views, i.album_id, null AS torrent_id, 0 AS position, 0 AS cover, i.id FROM images i;


REPLACE INTO `images_guests`(`id`, `url`, `main_url`, `tiny_url`, `filename`, `show_filename`, `size`, `width`, `height`, `guest_key`, `added`, `comment`, `exif`, `tag_id`, `access`, `rating`, `views`, `torrent_id`, `position`, `cover`) SELECT null, `url`, `main_url`, `tiny_url`, `filename`, `show_filename`, `size`, `width`, `height`, `guest_key`, `added`, `comment`, `exif`, `tag_id`, `access`, `rating`, `views`, `torrent_id`, `position`, `cover` FROM `pictures` WHERE `guest_key` IS NOT NULL;

REPLACE INTO `images`(`id`, `url`, `main_url`, `tiny_url`, `filename`, `show_filename`, `size`, `width`, `height`, `user_id`, `added`, `comment`, `exif`, `tag_id`, `album_id`, `access`, `net_id`, `rating`, `views`) SELECT null,`url`, `main_url`, `tiny_url`, `filename`, `show_filename`, `size`, `width`, `height`, `user_id`, `added`, `comment`, `exif`, `tag_id`, `album_id`, `access`, null, `rating`, `views` FROM `pictures` WHERE `guest_key` IS NULL;

INSERT INTO `new_image_screens`(`image_id`, `torrent_id`, `url`, `position`) SELECT `id`, `torrent_id`, `url`, `position` FROM `pictures` WHERE `cover` != 1 AND `torrent_id` IS NOT NULL;

REPLACE INTO `image_screens`(`image_id`, `torrent_id`, `url`, `position`) SELECT `id`, `torrent_id`, `url`, `position` FROM `images_guests` WHERE `cover` != 1;

INSERT INTO `imghost_seedoff`.`new_image_screens`(`image_id`, `torrent_id`, `url`, `position`) SELECT `id`, `torrent_id`, `url`, `position` FROM `imghostpro`.`pictures` WHERE `cover` != 1 AND `torrent_id` IS NOT NULL and `position` IS NOT NULL;




