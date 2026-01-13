CREATE TABLE `pet_type` (
  `type_id` int(1) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `vaccine` (
  `vaccine_id` int(3) NOT NULL AUTO_INCREMENT,
  `vaccine_name` varchar(50) NOT NULL,
  `vaccine_price` double NOT NULL,
  `type` int(1) NOT NULL,
  `status` enum('available','unavailable') NOT NULL,
  PRIMARY KEY (`vaccine_id`),
  KEY `type` (`type`),
  CONSTRAINT `vaccine_ibfk_1` FOREIGN KEY (`type`) REFERENCES `pet_type` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

CREATE TABLE `owner` (
  `owner_id` int(3) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

CREATE TABLE `staff` (
  `staff_id` int(3) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('vet','admin') NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

CREATE TABLE `news` (
  `news_id` int(3) NOT NULL AUTO_INCREMENT,
  `news_name` varchar(50) NOT NULL,
  `news_detail` varchar(200) NOT NULL,
  `path` varchar(150) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `create_date` datetime NOT NULL,
  `create_by` int(3) NOT NULL,
  `news_content` varchar(8000) NOT NULL,
  PRIMARY KEY (`news_id`),
  KEY `create_by` (`create_by`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`create_by`) REFERENCES `staff` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

CREATE TABLE `appointment_type` (
  `appointment_type_id` int(1) NOT NULL AUTO_INCREMENT,
  `appointment_type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`appointment_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `pet` (
  `pet_id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` int(1) NOT NULL,
  `age` int(3) NOT NULL,
  `breed` varchar(50) DEFAULT NULL,
  `gender` enum('female','male') NOT NULL,
  `path` varchar(150) NOT NULL,
  `owner_id` int(3) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`pet_id`),
  KEY `type` (`type`),
  KEY `owner_id` (`owner_id`),
  CONSTRAINT `pet_ibfk_1` FOREIGN KEY (`type`) REFERENCES `pet_type` (`type_id`),
  CONSTRAINT `pet_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

CREATE TABLE `appointment` (
  `appointment_id` int(3) NOT NULL AUTO_INCREMENT,
  `pet_id` int(3) NOT NULL,
  `type` int(1) NOT NULL,
  `date` date NOT NULL,
  `time` enum('10:00-11:00','11:00-12:00','13:00-14:00','14:00-15:00','15:00-16:00','16:00-17:00') NOT NULL,
  `create_date` datetime NOT NULL,
  `status` enum('cancelled','in process','finished') NOT NULL,
  `update_by` int(3) DEFAULT NULL,
  `vaccine_id` int(3) DEFAULT NULL,
  `price` double NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `payment_status` enum('unpaid','completed') NOT NULL,
  `payment_update_date` datetime DEFAULT NULL,
  `payment_update_by` int(3) DEFAULT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `type` (`type`),
  KEY `pet_id` (`pet_id`),
  KEY `payment_update_by` (`payment_update_by`),
  KEY `update_by` (`update_by`),
  KEY `vaccine_id` (`vaccine_id`),
  CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`type`) REFERENCES `appointment_type` (`appointment_type_id`),
  CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`),
  CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`payment_update_by`) REFERENCES `staff` (`staff_id`),
  CONSTRAINT `appointment_ibfk_4` FOREIGN KEY (`update_by`) REFERENCES `staff` (`staff_id`),
  CONSTRAINT `appointment_ibfk_5` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccine` (`vaccine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;


-- ข้อมูลพื้นฐาน
INSERT INTO appointment_type
(appointment_type_id, appointment_type_name)
VALUES(1, 'Vaccination');
INSERT INTO appointment_type
(appointment_type_id, appointment_type_name)
VALUES(2, 'Health check');

INSERT INTO pet_type
(type_id, type_name)
VALUES(1, 'cat');
INSERT INTO pet_type
(type_id, type_name)
VALUES(2, 'dog');

-- user : admin@gmail.com password : admin
INSERT INTO staff
(staff_id, fname, lname, email, password, `role`)
VALUES(120, 'Manissara', 'Saejan', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin');
-- user : vet@gmail.com password : vet
INSERT INTO staff
(staff_id, fname, lname, email, password, `role`)
VALUES(121, 'Manissara', 'Saejan', 'vet@gmail.com', '2fe585b232995699edf68a537f91d31d', 'vet');


INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(1, 'วัคซีนป้องกันไวรัสไข้หัดสุนัข (CDV)', 790.0, 2, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(2, 'วัคซีนป้องกันเชื้ออะดิโนไวรัสในสุนัข (CAV)', 790.0, 2, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(3, 'วัคซีนป้องกันพิษสุนัขบ้า (rabies virus)', 490.0, 2, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(4, 'วัคซีนป้องกันไข้หัดแมว (FPV)', 690.0, 1, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(5, 'วัคซีนแคลิซิไวรัส (FCV)', 690.0, 1, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(6, 'วัคซีนป้องกันพาราอินฟลูเอนซ่าไวรัส (CPiV)', 690.0, 2, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(7, 'วัคซีนป้องกันเชื้อ Leptospira interrogans', 790.0, 2, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(8, 'วัคซีนลิวคีเมีย (eline leukemia virus)', 790.0, 1, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(9, 'วัคซีนป้องกันการติดเชื้อ Chlamydophila ', 790.0, 1, 'available');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(10, 'วัคซีนป้องกันเอดส์แมว (FIV)', 790.0, 1, 'unavailable');
INSERT INTO vaccine
(vaccine_id, vaccine_name, vaccine_price, `type`, status)
VALUES(11, 'วัคซีนป้องกันโรคเยื่อบุช่องท้องอักเสบในแมว (FIP)', 690.0, 1, 'unavailable');

INSERT INTO news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(8, 'ห้องน้ำแมวอัตโนมัติปลอดภัยจริงหรือไม่', 'มาไขข้อสงสัยเกี่ยวกับห้องน้ำแมวอัตโนมัติ', 'image-upload/news/20240506_152850_4.png', 'active', '2024-05-06 08:28:50', 120, '<p><span style="color:#000000;">เชื่อว่าทาสแมวหลาย ๆ คน ต้องมีตัวเลือกห้องน้ำแมวอัตโนมัติเป็นอันดับต้น ๆ เนื่องจากง่าย สามารถทำความสะอาดได้เอง ทาสแมวอย่างเรา ๆ มีหน้าที่แค่นำไปทิ้งเฉย ๆ</span></p><p><span style="color:#000000;">จากโพสต์เตือนภัยของคนเลี้ยงแมวท่านหนึ่ง ที่ออกมาเตือนภัยสาวกคนเลี้ยงแมวเกี่ยวกับห้องน้ำแมวอัตโนมัติ ที่หนีบคอของแมวที่เธอเลี้ยงจนขาดอากาศหายใจ และเสียชีวิตไปในที่สุด อาจจะทำให้หลาย ๆ คนกลัวความไม่ปลอดภัยกับห้องน้ำแมวอัตโนมัติ</span></p><p><span style="color:#000000;">วันนี้แอดมินเลยจะมาไขข้อสงสัยเกี่ยวกับประเด็นที่ว่า ห้องน้ำแมวอัตโนมัติปลอดภัยจริงหรือไม่ จากทางต้นโพสต์ของหญิงสาวที่แชร์ข้อมูลเตือนภัย ยี่ห้อที่เลือกใช้เป็นยี่ห้อที่ตัดวงจรเซนเซอร์กันหนึบออก และเหลือเพียงเซอเซอร์วัดน้ำหนัก เนื่องจากเซอเซอร์กันหนึบทำให้แผงจรพัง ชำรุดเสียหายง่าย สรุปได้ง่าย ๆ ก็คือ ห้องน้ำแมวอัตโนมัติไม่ได้ไม่ปลอดภัยอย่างที่คิด แต่ต้องเลือกยี่ห้อที่ไม่ได้ตัดเซนเซอร์กันหนึบออก เพราะเป็นเซนเซอร์ที่ป้องกันการทำงานผิดพลาดของเซอเซอร์วัดน้ำหนักตัว ดังนั้น เพื่อน ๆ สบายใจได้ถ้าหากจะใช้ห้องน้ำแมว แต่อย่าลืมตรวจเช็คยี่ห้อดี ๆ ก่อนให้เจ้านายของคุณใช้นะ เซนเซอร์กันหนีบเป็นเรื่องที่สำคัญจริง ๆ</span></p><p>&nbsp;</p>');
INSERT INTO `66102010151`.news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(9, 'อาหารที่สุนัขไม่ควรรับประทาน', 'อาหารบางชนิดที่คนทาน สุนัขไม่สามารถทานได้', 'image-upload/news/20240506_170449_3.png', 'active', '2024-05-06 10:04:49', 120, '<p><span style="color:#000000;">ในหลาย ๆ ครั้ง เวลาที่เรากำลังกินอาหารอยู่ดี ๆ เจ้าเพื่อนแสนซนก็ชอบมาทำตาแป๋วขอกินด้วยจนบางทีก็อดใจไม่แบ่งให้ไม่ได้ แต่ช้าก่อน! รู้หรือไม่ว่าอาหารบางอย่างที่คนกินนั้น&nbsp;</span><br><span style="color:#000000;">น้องหมา น้องแมวไม่สามารถกินได้นะคะ เพราะฉะนั้นก่อนให้ต้องเช็คดูให้ดีก่อน<strong>&nbsp;เพราะบางอย่างอาจทำให้น้องถึงขั้นเสียชีวิตได้เลยทีเดียว&nbsp;</strong>อาหารที่น้อง ๆ กินไม่ได้จะมีอะไรบ้าง</span></p><ul><li><span style="color:#000000;"><strong>ช็อกโกแลต กาแฟ เครื่องดื่มคาเฟอีน</strong></span><br><span style="color:#000000;">มีสารที่เรียกว่า&nbsp;methylxanthines&nbsp;อยู่ หากสัตว์เลี้ยงกินเข้าไปจะทำให้เกิดอาการอาเจียน ท้องเสีย หอบเหนื่อย กระหายน้ำ ปัสสาวะบ่อย มีภาวะการเต้นหัวใจที่ผิดปกติ ตัวสั่น และอาจถึงขั้นเสียชีวิตได้ ยิ่งช็อกโกแลตมีสีเข้ม ก็จะยิ่งมีสารชนิดนี้เยอะ เพราะฉะนั้นดาร์กช็อกโกแลตถือว่าอันตรายสุดๆ</span></li><li><span style="color:#000000;"><strong>อโวคาโด</strong></span><br><span style="color:#000000;">มีสารพิษที่เรียกว่า&nbsp;Persin&nbsp;อยู่ ถึงแม้จะอันตรายต่อหมาค่อนข้างน้อย ก็ไม่ควรให้กินในปริมาณมากอยู่ดี เพราะจะทำให้เกิดอาการอาเจียน และท้องเสียได้</span></li><li><span style="color:#000000;"><strong>ถั่วแมคคาเดเมีย</strong></span><br><span style="color:#000000;">มีสารพิษที่เป็นอันตรายต่อน้องหมา เพราะจะทำให้เกิดอาการกล้ามเนื้ออ่อนแรง ตัวสั่น ชัก ซึม และอาเจียน โดยอาการจะแสดงหลังกินเข้าไปประมาณ&nbsp;12&nbsp;ชม. และสามารถอยู่ได้นานถึง&nbsp;48&nbsp;ชม.</span></li><li><span style="color:#000000;"><strong>กระเทียม หัวหอม</strong></span><br><span style="color:#000000;">หากกินเข้าไปจะทำให้เกิดอาการระคายเคืองต่อกระเพาะอาหารและลำไส้ และสามารถนำไปสู่การทำลายเซลล์เม็ดเลือดแดง ซึ่งทำให้เกิดโรคโลหิตจางได้&nbsp;</span></li><li><span style="color:#000000;"><strong>ของที่มีรสเค็ม</strong></span><br><span style="color:#000000;">หากได้รับปริมาณของเกลือที่มากเกินไป จะทำให้เกิดอาการกระหายน้ำ ตามมาด้วยปัสสาวะบ่อย ซึ่งสัญญานที่บ่งบอกว่าได้รับเกลือมากเกินไปคือเริ่มอาเจียน ท้องเสีย อุณหภูมิในร่างกายสูงขึ้น มีอาการสั่น ชัก จนถึงขั้นเสียชีวิต</span><br>&nbsp;</li></ul><p><span style="color:#1f3863;"><strong>รู้อย่างนี้แล้ว ไม่ว่าจะโดนทำหน้าอ้อนขนาดไหน ก็ต้องอย่าใจอ่อน และช่วยกันเตือนคนที่บ้านว่าอย่าให้น้องหมา น้องแมวกินอาหารเหล่านี้เลยนะคะ เพื่อสุขภาพที่แข็งแรง น้อง ๆ จะได้อยู่กับเราไปนาน ๆ&nbsp;</strong></span></p><p><span style="color:#000000;">Cr. </span><a href="https://www.muangthaiinsurance.com/livecoaching/blog/detail/136"><span style="color:hsl( 0, 0%, 0% );">https://www.muangthaiinsurance.com/livecoaching/blog/detail/136</span></a></p>');
INSERT INTO `66102010151`.news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(10, 'สามโรคฮิตของน้องหมาปอม', 'รู้ไว้ไม่สาย สามโรคฮิตของสุนัขพันธ์ปอมเอมเรเนียน
', 'image-upload/news/20240506_170805_2.png', 'active', '2024-05-06 10:08:05', 120, '<p><span style="color:#575757;">โดยทั่วไปแล้วน้องหมาแต่ละสายพันธุ์ก็จะมีโรคประจำพันธุ์ที่แตกต่างกันออกไป เช่นเดียวกันกับน้องหมาขนพองแสนน่ารักอย่างน้องปอม อีกหนึ่งพันธุ์ยอดฮิตที่นิยมเลี้ยงกันในบ้านเรา วันนี้แอดมินจึงเอาใจเหล่าคนรักน้องปอมเป็นพิเศษด้วยการแนะนำ&nbsp;3&nbsp;โรคยอดฮิตในน้องหมาพันธุ์ปอม สำหรับคนที่กำลังเลี้ยงน้อง ๆ อยู่หรือวางแผนจะเลี้ยงน้องในอนาคตให้ทราบเพื่อเป็นอีกหนึ่งแนวทางในการดูแลสุขภาพน้องปอมเบื้องต้นกัน</span></p><ul><li><span style="color:#575757;"><strong>โรคสะบ้าเคลื่อน</strong></span></li></ul><p><span style="color:#575757;">โรคสะบ้าเคลื่อนเป็นโรคที่มาคู่กับน้องหมาพันธุ์ปอมจริงๆ ซึ่งเกิดมาจากการที่ลูกสะบ้าเคลื่อนออกจากร่องกระดูก ทำให้น้องหมาร้องเพราะเจ็บปวด เดินผิดปกติ เจ็บขา เดินยกขา ไม่สามารถเหยียดข้อขาได้ ไม่ลงน้ำหนักเท้า ยิ่งถ้าน้องเป็นหนักก็อาจมีการบิดของกระดูกขาร่วมด้วย เพื่อป้องกันไม่ให้เกิดโรคนี้ เราขอแนะนำให้คุณเจ้าของเลี่ยงไม่ให้น้อง ๆ มีการเคลื่อนไหวที่ส่งผลกระทบต่อกระดูกข้อเข่า เช่น การกระโดดจากที่สูงหรือกระแทกกับอะไรแรง ๆ ไม่ให้เดินบนพื้นลื่น ๆ อย่างพื้นหินอ่อน และหินแกรนิต ตัดขนเท้าให้เรียบ ควบคุมน้ำหนักไม่ให้เกินเกณฑ์ และปรึกษาแพทย์เพื่อให้น้อง ๆ ทานอาหารเสริมเพื่อบำรุงร่างกาย</span></p><ul><li><span style="color:#575757;"><strong>โรคหลอดลมตีบ</strong></span></li></ul><p><span style="color:#575757;">เวลาที่คุณเจ้าของสังเกตเห็นน้อง ๆ มีอาการไอแห้ง ๆ คล้ายกับห่านหรือหายใจหอบเสียงดังเวลาที่รู้สึกตื่นเต้น ออกกำลังกายหรืออากาศเย็น ๆ คงจะไม่พ้นโรคหลอดลมตีบอย่างแน่นอน ต้นเหตุของโรคนี้เกิดมาจากอวัยวะที่เชื่อมต่อจากกล่องเสียงไปยังปอด ซึ่งประกอบไปด้วยกระดูกอ่อนที่มีลักษณะคล้ายตัว&nbsp;C&nbsp;เมื่อกระดูกอ่อนในบริเวณหลอดลมดังกล่าวอ่อนตัว จึงทำให้หลอดลมแบนยุบตัวลงมา ส่งผลให้เกิดการอุดตันที่ท่อทางเดินหายใจ และหลอดลมตีบแคบ น้อง ๆ จึงรับออกซิเจนไม่มีเพียงพอ หายใจลำบาก เกิดภาวะลิ้นม่วง และมีโอกาสเสียชีวิตได้ เราสามารถช่วยน้อง ๆ ได้โดยการควบคุมน้ำหนักของน้องๆ ให้อยู่ในเกณฑ์เพื่อไม่ให้รู้สึกเหนื่อยง่ายหรือไขมันจุกอก ใช้สายรัดอกแทนสายปลอกคอ และเลี่ยงไม่ให้น้องสัมผัสกับอากาศชื้นหรือเย็นจนเกินไป</span></p><ul><li><span style="color:#575757;"><strong>โรคขนร่วงโดยไม่ทราบสาเหตุ</strong></span></li></ul><p><span style="color:#575757;">โรคนี้มักจะพบบ่อยในน้องปอมเพศผู้มากกว่าเพศเมีย ซึ่งทางแพทย์ผู้เชี่ยวชาญคาดว่า จะเกิดจากพันธุกรรมจากแม่ของน้อง ๆ อย่างโรค&nbsp;Black Skin&nbsp;หรือผิวหนังสีดำที่มาคู่กับน้องหมาพันธุ์นี้เลยก็ว่าได้ เบื้องต้นน้องหมาจะขนร่วงบริเวณช่วงท้ายของลำตัว หาง สะโพกและท้ายทอย ผิวหนังที่ขนร่วงก็จะกลายเป็นสีดำเนื่องจากเกิดการสะสมของเม็ดสีนั่นเอง แนวโน้มมาจากการพัฒนาของต่อมขนผิดปกติ ฮอร์โมนไทรอยด์ต่ำผิดปกติ ไรขี้เรื้อน และเชื้อรา เป็นต้น ในปัจจุบันยังไม่มีการรักษาโรคนี้โดยเฉพาะ อาจต้องให้แพทย์ตรวจเพื่อหาต้นตอของโรค แต่ในความจริงแล้วโรคนี้อาจไม่ได้ส่งผลต่อสุขภาพของน้อง ๆ แต่อาจจะทำให้น้อง ๆ ดูไม่สวยไม่หล่อกันเท่านั้นเอง เป็นอย่างไรกันบ้างครับกับโรคนี้เรามาแนะนำให้กับคนรักน้องปอมในวันนี้ โรคดังกล่าวเป็นเพียงแค่โรคหลัก ๆ ที่พบบ่อยเพียงเท่านั้น ยังไงเหล่าคนรักน้องหมาก็อย่าลืมที่จะสังเกต และหมั่นพาน้องหมาไปตรวจสุขภาพเป็นประจำด้วยนะ</span></p><p><span style="color:hsl(0, 0%, 0%);">Cr.&nbsp;</span><a href="https://www.spectrafordog.com/TH/protect/3_common_diseases_in_pomeranian_dog.html"><span style="color:hsl(0, 0%, 0%);">https://www.spectrafordog.com/TH/protect/3_common_diseases_in_pomeranian_dog.html</span></a></p>');
INSERT INTO `66102010151`.news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(11, 'วัคซีนพิษสุนัขฟรี ณ ชุมชนมหาสิน', 'ขอเชิญชวนน้องแมวและสุนัขมารับวัคซีนฟรี', 'image-upload/news/20240506_171824_1.png', 'active', '2024-05-06 10:18:24', 120, '<p><span style="color:hsl(0, 0%, 30%);"><strong>โรคพิษสุนัขบ้าคืออะไร ?&nbsp;</strong></span></p><p><span style="color:hsl(0, 0%, 30%);">โรคพิษสุนัขบ้า หรือโรคกลัวน้ำเป็นโรคติดเชื้อในระบบประสาทจากสัตว์สู่คน มีอันตรายร้ายแรงถึงชีวิต ปัจจุบันยังไม่มีการรักษา แต่โรคพิษสุนัขบ้าเป็นโรคที่สามารถป้องกันได้โดยการฉีดวัคซีน</span></p><p><span style="color:hsl(0, 0%, 30%);">เราขอเรียนเชิญชวนเจ้าของแมวและสุนัขทุกท่านในชุมชนมหาสิน ร่วมรับบริการรับวัคซีนพิษสุนัขบ้าฟรีในวันพุธที่ 20 พฤษภาคม 2566</span></p><p><span style="color:hsl(0, 0%, 30%);"><strong>รายละเอียดบริการ</strong></span></p><ul><li><span style="color:hsl(0, 0%, 30%);">วันและเวลา: วันพุธที่ 20 พฤษภาคม 2566 เวลา 09:00 น. - 16:00 น.</span></li><li><span style="color:hsl(0, 0%, 30%);">สถานที่: ชุมชนมหาสิน ถนนสุขุมวิท 101/1 แขวงบางนา เขตบางนา กรุงเทพมหานคร 10260</span></li><li><span style="color:hsl(0, 0%, 30%);">การรับบริการ: บริการจะให้แก่สุนัขทุกตัวที่มีอายุตั้งแต่ 3 เดือนขึ้นไป</span></li><li><span style="color:hsl(0, 0%, 30%);">วัคซีนที่ให้บริการ: รับวัคซีนพิษสุนัขบ้า (Rabies Vaccine)</span></li></ul><p>&nbsp;</p><p><span style="color:hsl(0, 0%, 30%);"><strong>เงื่อนไขและข้อควรระวัง</strong>:</span></p><ul><li><span style="color:hsl(0, 0%, 30%);">เจ้าของสุนัขควรนำสุนัขมาพร้อมใบรับรองการฉีดวัคซีนก่อนหน้า (ถ้ามี)</span></li><li><span style="color:hsl(0, 0%, 30%);">กรุณาคำนึงถึงความปลอดภัยของสุนัขและผู้อื่นๆในระหว่างการเข้ารับบริการ</span></li></ul>');
INSERT INTO `66102010151`.news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(12, '5 Dog can go, pet friendly ', 'มาทำความรู้จัก 5 สถานที่ที่อนุญาตให้สุนัขเข้าได้', 'image-upload/news/20240506_172717_1.png', 'active', '2024-05-06 10:27:17', 120, '<p><span style="color:hsl(0, 0%, 30%);">เชื่อว่าหลาย ๆ คน คงอยากพาเพื่อนรักสี่ขาไปทำกิจกรรมนอกบ้านด้วย อย่างเช่น คาเฟ่ ล่องเรือ หรือพาเจ้าสี่ขาไปทานไอศกรีมด้วยกัน แต่ติดปัญหาว่าหลาย ๆ ที่ไม่อนุญาตให้นำสัตว์เลี้ยงเข้า วันนี้แอดมินเลยขอนำเสนอ&nbsp;5&nbsp;โลเคชั่น&nbsp;pet friend&nbsp;ที่ควรพาเจ้าเพื่อนซี้&nbsp;check in !</span></p><p>&nbsp;</p><ul><li><a href="https://www.facebook.com/Koffeethai/?locale=th_TH"><span style="color:hsl(0, 0%, 30%);"><strong>Koffee Thai by&nbsp;บ้านน้ำเรือนศิลป์</strong></span></a><span style="color:hsl(0, 0%, 30%);"><strong>&nbsp;</strong>จังหวัดฉะเชิงเทรา</span></li></ul><p><span style="color:hsl(0, 0%, 30%);">คาเฟ่เล็ก ๆ ตกแต่งแบบมินิมอล เปิดเฉพาะวันศุกร์ เสาร์ อาทิตย์เท่านั้น อย่าลืมเช็ควันก่อนมาแวะนะ สามารถนั่งเรือจากตลาดโบราณนครเนื่องเขตมาที่หน้าคาเฟ่ได้เลยมีบริการรับส่งฟรี สามารถพาสัตว์เลี้ยงนั่งด้านนอกโซน&nbsp;Out door ได้ ส่วนเมนูก็มีให้เลือกหลากหลายทั้งของคาว ของหวาน แต่ตัวที่เป็นซิกเนเจอร์ของที่นี่จะเป็นพิซซ่าถาดหลุม ชีสเน้นๆ แอดมินแนะนำว่าควรพกน้ำดื่มสำหรับสัตว์เลี้ยงมาด้วย เพราะทางร้านไม่มีบริการให้</span></p><p>&nbsp;</p><ul><li><a href="https://www.facebook.com/longhaulcafe/"><span style="color:hsl(0, 0%, 30%);"><strong>Longhaul Cafe -&nbsp;ร้านลองฮอล</strong></span></a><span style="color:hsl(0, 0%, 30%);">&nbsp;ถนนสุขุมวิท&nbsp;107&nbsp;เขตบางนา</span></li></ul><p><span style="color:hsl(0, 0%, 30%);">เอาใจมะหมาขี้ร้อน ทางร้านเป็น&nbsp;pet friendly&nbsp;ทั้ง&nbsp;indoor&nbsp;และ&nbsp;out door สามารถสั่งขนมหรือน้ำหวานจุบจิบ และใช้เวลากับสัตว์เลี้ยงตัวโปรดได้เต็มที่เลย อย่าลืมรักษาความสะอาด เก็บปุ๊งของเด็ก ๆ และเตรียมน้ำดื่มสำหรับสัตว์เลี้ยงมาเองด้วยนะ</span></p><p>&nbsp;</p><ul><li><a href="https://web.facebook.com/Vino-Caf%C3%A9-Wine-Bar-101054594730199/?__cft__%5B0%5D=AZUN1N9lxelCYTd0LksWr2LX_YJfhyyq-QSPp9VZWgLF8XlGctHmtvidQgXrRPxx0lER992-FKZ07rEce9A6hvi-K0LLFBIOBRZnE01yq7di3eaLqp-vn0dDyA8raY2QPes6lwkthwTK17p0Wm0RnXguHvVahpRa7UIJzC4xk3ihTg&amp;__tn__=kK-R"><span style="color:hsl(0, 0%, 30%);"><strong>Vino Café &amp; Wine Bar</strong></span></a><span style="color:hsl(0, 0%, 30%);"> เขาใหญ่</span></li></ul><p><span style="color:hsl(0, 0%, 30%);">เอาใจคอกาแฟไป&nbsp;2&nbsp;ที่แล้ว ขอเปลี่ยนแนวเอาใจสายจิบไวน์ที่รักมะหมาบ้าง หากใครชอบเสพบรรยากาศเหมือนกรุงปารีส ประเทศฝรั่งเศส แนะนำว่าไม่ควรพลาดที่นี่ ยิ่งช่วงเย็น ๆ ไปจนถึงหัวค่ำ พระอาทิตย์ตกสวย เหมาะสำหรับการถ่ายรูปเจ้ามะหมาอัพลงช่องทางโซเชียลมีเดียอวดสมาคมคนรักเจ้าตูบมาก ๆ แนะนำว่าควรจองก่อน เพื่อจะได้นั่งโต๊ะที่เห็นวิวครบ</span></p><p>&nbsp;</p><ul><li><a href="https://maps.app.goo.gl/xKxhDnTUnwxQabzp9?g_st=ic"><span style="color:hsl(0, 0%, 30%);"><strong>Myrrh. Cafe</strong></span></a><span style="color:hsl(0, 0%, 30%);"> เขาใหญ่</span></li></ul><p><span style="color:hsl(0, 0%, 30%);">คาเฟ่เล็ก ๆ ที่ตกแต่งสีขาวสะอาดตา ทางร้านมีกฎว่าขอให้สัตว์เลี้ยงอยู่ในรถเข็นเท่านั้นเพื่อรักษาความสะอาด ทางร้านมีขนมเสิร์ฟสำหรับเพื่อนซี้ตัวจิ๋วของลูกค้าด้วย แอดมินแนะนำว่าใครที่ไปเขาใหญ่อย่าพลาดร้านนี้ เพราะเค้กมะพร้าวซิกเนเจอร์ของทางร้านรสชาติกลมกล่อมพอดีมาก ทำเอาอยากขับรถกับมะหมาไปถึงเขาใหญ่เพื่อกินอีกรอบเลย</span></p><p>&nbsp;</p><ul><li><a href="https://web.facebook.com/tongsomboonclub?__cft__%5B0%5D=AZUN1N9lxelCYTd0LksWr2LX_YJfhyyq-QSPp9VZWgLF8XlGctHmtvidQgXrRPxx0lER992-FKZ07rEce9A6hvi-K0LLFBIOBRZnE01yq7di3eaLqp-vn0dDyA8raY2QPes6lwkthwTK17p0Wm0RnXguHvVahpRa7UIJzC4xk3ihTg&amp;__tn__=-%5DK-R"><span style="color:hsl(0, 0%, 30%);"><strong>ทองสมบูรณ์คลับ&nbsp;Thongsomboonclub Pakchong</strong></span></a><span style="color:hsl(0, 0%, 30%);"><strong> </strong></span><span style="color:rgb(32,33,36);">อำเภอปากช่อง นครราชสีมา</span></li></ul><p><span style="color:hsl(0,0%,30%);">แนะนำคาเฟ่สไตล์มินิมอลไปเยอะแล้ว ขอเปลี่ยนสไตล์เป็นที่ท่องเที่ยวแนวกิจกรรมของเพื่อนรักสี่ขาบ้างดีกว่า โลเคชั่นยังอยู่ที่เขาใหญ่เหมือนเดิม มีกิจกรรมให้ใช้เวลาร่วมกันอย่างสนุกสนานได้ทั้งวัน&nbsp;มีทั้งกระเช้าลอยฟ้า ขับ&nbsp;luge&nbsp;ขี่ม้า ที่พูดมายังไม่หมดเลย เพราะมีกิจกรรมอีกเยอะมาก ๆ ถ้าหากไปแนะนำว่าควรมีคนดูแลเจ้ามะหมาไม่ห่างตัวตลอดเวลานะ&nbsp;!&nbsp;เพราะสถานที่ค่อนข้างกว้าง อาจจะเกินการพลัดหลงได้</span></p>');
INSERT INTO `66102010151`.news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(13, 'แมวดำนำโชคร้ายจริงหรือ?', 'ไขข้อสงสัยความเชื่อเรื่องแมวดำ', 'image-upload/news/20240506_173414_5.png', 'active', '2024-05-06 10:34:14', 120, '<p><span style="color:hsl(0,0%,30%);">จากความเชื่อตั้งแต่สมัยโบราณ ทำให้ปัจจุบันหลายคนยังมีแนวคิดว่าแมวดำจะนำพาโชคร้ายมาให้ เนื่องจากตัวสีดำ เป็นอัปมงคล แต่วันนี้แอดมินจะมาไขข้อสงสัยว่าแมวดำนำโคร้ายจริงหรือไม่</span></p><p><span style="color:hsl(0,0%,30%);">ความเชื่อเกี่ยวกับแมวดำ มีมาหลายศตวรรษแล้ว บ้างก็ว่าแมวดำเป็นสัญลักษณ์ของโชคร้าย บ้างก็ว่าแมวดำเป็นสัตว์เลี้ยงของแม่มด บ้างก็ว่าแมวดำเป็นสัตว์ที่จะนำพาความโชคร้ายมาสู่คนที่พบเห็น แต่ความจริงแล้วแมวดำก็คือแมวตัวหนึ่งไม่ได้นำความโชคร้ายอะไรเลย รวมไปถึงบางประเทศรวมไปถึงประเทศไทย ยังมีความเชื่อด้วยว่าจริงๆ แล้ว แมวดำเป็นแมวมงคลและนำโชค เช่น ในไอร์แลนด์ สกอตแลนด์ หรือแม้แต่อังกฤษที่เชื่อว่าหากแมวดำตัดหน้าจะเป็นเรื่องดี</span></p><figure class="image image_resized" style="width:36.02%;"><img src="../../../image-upload/news/20240506_174614_BlackCat.jpg"></figure><p><span style="color:hsl(0,0%,30%);">แมวดำ ลักษณะขนปกคลุมสีดำทั้งตัว ทุกคนรู้หรือไม่ว่าแมวดำไม่ได้นำโชคร้ายแบบที่คิด เป็นแมวธรรมดา ๆ เลย และจากข้อมูลเบื้องต้น สัตว์แพทย์บอกว่าแมวดำจะนิสัยขี้อ้อน และเชื่อฟังมากกว่าแมวสีอื่น ๆ ด้วยนะ ดังนั้นทุกคนสบายใจได้เลย และฝากเอ็นดูเจ้าแมวเหมียวขนปุยตัวสีดำทุกตัวบนโลกนี้ด้วยนะ</span></p>');
INSERT INTO `66102010151`.news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(14, '5 อาหารต้องห้ามสำหรับน้องแมว', 'มาทำความรู้จักอาหาร 5 ชนิดที่น้องแมวไม่สามารถทานได้', 'image-upload/news/20240506_173633_3.png', 'active', '2024-05-06 10:36:33', 120, '<p><span style="color:hsl(0, 0%, 30%);">ในหลาย ๆ ครั้ง เวลาที่เรากำลังกินอาหารอยู่ดี ๆ เจ้าเพื่อนแสนซนก็ชอบมาทำตาแป๋วขอกินด้วยจนบางทีก็อดใจไม่แบ่งให้ไม่ได้ แต่ช้าก่อน! รู้หรือไม่ว่าอาหารบางอย่างที่คนกินนั้น&nbsp;</span><br><span style="color:hsl(0, 0%, 30%);">น้องหมา น้องแมวไม่สามารถกินได้นะคะ เพราะฉะนั้นก่อนให้ต้องเช็คดูให้ดีก่อน<strong>&nbsp;เพราะบางอย่างอาจทำให้น้องถึงขั้นเสียชีวิตได้เลยทีเดียว&nbsp;</strong>อาหารที่น้อง ๆ กินไม่ได้จะมีอะไรบ้าง</span></p><ul><li><span style="color:hsl(0, 0%, 30%);"><strong>ช็อกโกแลต กาแฟ เครื่องดื่มคาเฟอีน</strong></span><br><span style="color:hsl(0, 0%, 30%);">มีสารที่เรียกว่า&nbsp;methylxanthines&nbsp;อยู่ หากสัตว์เลี้ยงกินเข้าไปจะทำให้เกิดอาการอาเจียน ท้องเสีย หอบเหนื่อย กระหายน้ำ ปัสสาวะบ่อย มีภาวะการเต้นหัวใจที่ผิดปกติ ตัวสั่น และอาจถึงขั้นเสียชีวิตได้ ยิ่งช็อกโกแลตมีสีเข้ม ก็จะยิ่งมีสารชนิดนี้เยอะ เพราะฉะนั้นดาร์กช็อกโกแลตถือว่าอันตรายสุดๆ</span></li><li><span style="color:hsl(0, 0%, 30%);"><strong>อโวคาโด</strong></span><br><span style="color:hsl(0, 0%, 30%);">มีสารพิษที่เรียกว่า&nbsp;Persin&nbsp;อยู่ ถึงแม้จะอันตรายต่อหมาค่อนข้างน้อย ก็ไม่ควรให้กินในปริมาณมากอยู่ดี เพราะจะทำให้เกิดอาการอาเจียน และท้องเสียได้</span></li><li><span style="color:hsl(0, 0%, 30%);"><strong>ถั่วแมคคาเดเมีย</strong></span><br><span style="color:hsl(0, 0%, 30%);">มีสารพิษที่เป็นอันตรายต่อน้องหมา เพราะจะทำให้เกิดอาการกล้ามเนื้ออ่อนแรง ตัวสั่น ชัก ซึม และอาเจียน โดยอาการจะแสดงหลังกินเข้าไปประมาณ&nbsp;12&nbsp;ชม. และสามารถอยู่ได้นานถึง&nbsp;48&nbsp;ชม.</span></li><li><span style="color:hsl(0, 0%, 30%);"><strong>กระเทียม หัวหอม</strong></span><br><span style="color:hsl(0, 0%, 30%);">หากกินเข้าไปจะทำให้เกิดอาการระคายเคืองต่อกระเพาะอาหารและลำไส้ และสามารถนำไปสู่การทำลายเซลล์เม็ดเลือดแดง ซึ่งทำให้เกิดโรคโลหิตจางได้&nbsp;</span></li><li><span style="color:hsl(0, 0%, 30%);"><strong>ของที่มีรสเค็ม</strong></span><br><span style="color:hsl(0, 0%, 30%);">หากได้รับปริมาณของเกลือที่มากเกินไป จะทำให้เกิดอาการกระหายน้ำ ตามมาด้วยปัสสาวะบ่อย ซึ่งสัญญานที่บ่งบอกว่าได้รับเกลือมากเกินไปคือเริ่มอาเจียน ท้องเสีย อุณหภูมิในร่างกายสูงขึ้น มีอาการสั่น ชัก จนถึงขั้นเสียชีวิต</span><br>&nbsp;</li></ul><p><span style="color:hsl(0, 0%, 30%);"><strong>รู้อย่างนี้แล้ว ไม่ว่าจะโดนทำหน้าอ้อนขนาดไหน ก็ต้องอย่าใจอ่อน และช่วยกันเตือนคนที่บ้านว่าอย่าให้น้องหมา น้องแมวกินอาหารเหล่านี้เลยนะคะ เพื่อสุขภาพที่แข็งแรง น้อง ๆ จะได้อยู่กับเราไปนาน ๆ&nbsp;</strong></span></p><p><span style="color:hsl(0, 0%, 30%);">Cr. </span><a href="https://www.muangthaiinsurance.com/livecoaching/blog/detail/136"><span style="color:hsl(0, 0%, 30%);">https://www.muangthaiinsurance.com/livecoaching/blog/detail/136</span></a></p>');
INSERT INTO `66102010151`.news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(15, 'วิธีป้องกันโรคฮีทสโตรกในสุนัข', 'ทำความเข้าใจภาวะเพลียแดดและโรคฮีทสโตรกในสุนัขกัน', 'image-upload/news/20240506_173845_2.png', 'active', '2024-05-06 10:38:45', 120, '<p><span style="color:hsl(0,0%,30%);">ทำความเข้าใจภาวะเพลียแดดและโรคฮีทสโตรกในสุนัขกัน !</span></p><p><span style="color:hsl(0,0%,30%);"><strong>โรคฮีทสโตรกเกิดจากอะไร ?</strong></span><br><span style="color:hsl(0,0%,30%);">ภาวะเพลียแดดและฮีทสโตรกสุนัขเกิดจากความร้อนเหมือนกัน แต่มีข้อแตกต่างกันเล็กน้อย โดยอาจกล่าวได้ว่าภาวะเพลียแดดเป็นหนึ่งในสัญญาณเตือนระยะเริ่มแรกของฮีทสโตรก ภาวะเพลียแดดไม่รุนแรง น้องหมาอาจมีอาการหอบและน้ำลายไหลมากเท่านั้น แต่หากมองข้ามอาการเหล่านี้ ก็อาจนำไปสู่ภาวะฮีทสโตรกได้อย่างรวดเร็ว ซึ่งเป็นภาวะที่รุนแรงกว่าและเป็นอันตรายถึงชีวิต</span></p><p><span style="color:hsl(0,0%,30%);"><strong>วิธีป้องกันโรคฮีทสโตรกในสุนัข</strong></span></p><p><span style="color:hsl(0,0%,30%);">การเรียนรู้วิธีป้องกันอาการฮีทสโตรกตั้งแต่แรกก็เป็นสิ่งสำคัญเช่นเดียวกันกับวิธีรักษา</span></p><ol><li><span style="color:hsl(0,0%,30%);">หลีกเลี่ยงการปล่อยน้องหมาทิ้งไว้ในรถยนต์ที่จอดอยู่กับที่</span></li><li><span style="color:hsl(0,0%,30%);">จัดเตรียมมุมพักผ่อนที่ร่มรื่น อากาศถ่ายเท และเตรียมน้ำให้เพียงพอ</span></li><li><span style="color:hsl(0,0%,30%);">หลีกเลี่ยงการทำกิจกรรมกลางแจ้งในวันที่อากาศร้อนจัด</span></li><li><span style="color:hsl(0,0%,30%);">ดูแลน้องหมาที่มีความเสี่ยงสูงอย่างใกล้ชิด เช่น ลูกสุนัข น้องหมาสูงวัย น้องหมาที่มีขนหนา น้องหมาหน้าแบน เช่น ปั๊ก หรือน้องหมาที่กำลังใช้ยาบางชนิด</span></li></ol><p><span style="color:hsl(0,0%,30%);">โรคฮีทสโตรกในสุนัขเป็นปัญหาร้ายแรง แต่หากรู้วิธีรับมืออย่างเหมาะสม อาการก็จะบรรเทาลง ด้วยเหตุนี้ผู้เลี้ยงทุกคนจึงควรเรียนรู้และทำความเข้าใจโรคนี้กันให้ดี</span></p><p><span style="color:hsl(0,0%,30%);">อย่างไรก็ตาม ทุกคนสามารถพาน้องหมาออกไปเล่นคาบของหรือเดินเล่นในช่วงฤดูร้อนได้ตามปกติ แต่อย่าลืมสังเกตอาการสัตว์เลี้ยงของเราด้วยนะ</span></p>');
INSERT INTO `66102010151`.news
(news_id, news_name, news_detail, `path`, status, create_date, create_by, news_content)
VALUES(17, 'test', 'lllllllllllllllll', 'image-upload/news/20240509_121819_Test.jpg', 'active', '2024-05-09 05:18:19', 120, '<figure class="image"><img src="../../../image-upload/news/20240509_121811_Test.jpg"></figure>');