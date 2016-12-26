# piwigoScripts

piwigo scripts I made

--adddatecrated.php

if pictures/videos you add to piwigo do not have a date crated attribute (EXIF), then it is blank, which causes a out of order issue when you select the sort by 'Date Crated'.  If the date is in the filename, this will search for it via regular expressions and pull it out, all the way the the 'seconds'.
the following versions of filenames should work  1219160028.mp4  2015-12-05 20.29.08.mp4 2016-08-08 14.16.43.jpg  and Fubarr 16-12-25.pdf (Y-M-D)

If you comment out the 4 actual db calls (which should be made into a function, but I dont care about that right now) (they are at the end of each if(pattern**) (i do not know how i just made everything bold) 

The script will output each file and if it mattched a pattern.  The matched pattern will be first, then the file name.  ie 'pattern2    foobardonkeypics 2015-12-25 200000.jpg'  

-- addmd5.php
***you need add a column 'md5sum' to the table.  varchar(33)* 
checks current piwigo_images table md5sum column if any are 'null'.  then for each returned, uses the path to get the md5 via md5_file, then updates the row with the md5

Eventually I will change modify the synchronizing script to run a md5 on all 'newly found' photos and check it against current photos prior to adding, checking for dups[i see 2.9 beta has something, but i dont know how it implements it].  I will also modify it as if files are 'moved', they will not be fully removed from piwigo , but placed in a separate table so all of the album associations/tags/permissions, are saved [note: I do not use the actual directory structure as my albums, but as my upload directory, I plan on using associative albums.

--tomfindbadfilenames.php

uses the directory ./galleries, and searches each sub directory of it to find any file that has a paratheses.  if it finds one, it copies the file with the filename having the  paratheses replalced with a dash.  it also adds the new and old filename with path (including ./galleries/) to another database tabled i named imagescopied (int id auto_increment,varchar(255) copiedfrom,varchar(255) copiedto)[type col_name [options]]
