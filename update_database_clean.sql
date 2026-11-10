-- ==============================================================
-- মুক্তাদার বইঘর (Muktada's Boighor)
-- 100% SAFE UTF-8 REPAIR & UPDATE SQL (NO DUPLICATE KEY ERRORS)
-- ==============================================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- ১. ক্যারেক্টার সেট utf8mb4 এ রূপান্তর
ALTER TABLE `site_settings` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `books` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `categories` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `reviews` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `memberships` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ২. সাইট সেটিংস আপডেট (INSERT ... ON DUPLICATE KEY UPDATE)
INSERT INTO `site_settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
('site_name', 'মুক্তাদার বইঘর | Muktada''s Boighor', NOW(), NOW()),
('site_tagline', 'জ্ঞানের আলোয় নতুন পথচলা — ভালো বই, সুন্দর ভাবনা', NOW(), NOW()),
('author_name', 'মুক্তাদা', NOW(), NOW()),
('author_bio', 'লেখক, চিন্তক ও গবেষক। জীবন, সমাজ ও আত্মউন্নয়নমূলক সাহিত্যের মাধ্যমে মানুষের হৃদয় আলোকিত করাই তাঁর লেখার মূল উদ্দেশ্য। তাঁর প্রকাশিত বইগুলো পাঠকসমাজে ব্যাপক সমাদৃত হয়েছে।', NOW(), NOW()),
('author_quote', 'বই হলো মনের জানালা, যা মানুষকে সত্য ও সুন্দরের পথ দেখায়। সুন্দর জীবন গড়তে ভালো বইয়ের কোনো বিকল্প নেই।', NOW(), NOW()),
('author_photo', 'author-portrait.jpg', NOW(), NOW()),
('bkash_number', '01700-112233 (Merchant / Send Money)', NOW(), NOW()),
('nagad_number', '01800-445566 (Merchant)', NOW(), NOW()),
('upay_number', '01900-778899 (Personal)', NOW(), NOW()),
('payment_instruction', 'বিকাশ, নগদ বা উপায়-এ নির্ধারিত টাকা পাঠিয়ে Transaction ID এবং আপনার নম্বরটি দিন। তথ্য সঠিক হলে দ্রুত অর্ডার সম্পন্ন হবে।', NOW(), NOW()),
('delivery_charge_dhaka', '60', NOW(), NOW()),
('delivery_charge_outside', '120', NOW(), NOW()),
('contact_email', 'contact@muktadasbookhouse.com', NOW(), NOW()),
('contact_phone', '+880 1700-112233', NOW(), NOW()),
('contact_address', 'কনকর্ড টাওয়ার, শান্তিনগর, ঢাকা-১২১৭', NOW(), NOW()),
('facebook_url', 'https://facebook.com/muktadasbookhouse', NOW(), NOW()),
('whatsapp_number', '+8801700112233', NOW(), NOW()),
('youtube_url', 'https://youtube.com', NOW(), NOW()),
('availability_locations', '(১) সি এস ডি, ঢাকা সেনানিবাস, ঢাকা\n(২) রাওয়া পাবলিকেশন, রাওয়া কমপ্লেক্স, মহাখালী, ঢাকা', NOW(), NOW())
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = NOW();

-- ৩. ১০টি ক্যাটাগরির বাংলা নাম ও বিবরণ
UPDATE `categories` SET `name` = 'ইসলামিক', `description` = 'দ্বীন, জীবন ও আখেরাতের সঠিক পাথেয় সম্পর্কিত বই।', `sort_order` = 1 WHERE `slug` = 'islamic';
UPDATE `categories` SET `name` = 'উপন্যাস', `description` = 'সমাজ, প্রেম ও মানবিক অনুভূতির অনন্য আখ্যান।', `sort_order` = 2 WHERE `slug` = 'novels';
UPDATE `categories` SET `name` = 'গল্প', `description` = 'জীবনের ছোট ছোট অনুপ্রেরণামূলক গল্পের সমাহার।', `sort_order` = 3 WHERE `slug` = 'stories';
UPDATE `categories` SET `name` = 'আত্মজীবনী', `description` = 'বরেণ্য মনীষী ও মহৎ জীবনের শিক্ষা।', `sort_order` = 4 WHERE `slug` = 'biography';
UPDATE `categories` SET `name` = 'আত্মউন্নয়ন', `description` = 'ব্যক্তিত্ব বিকাশ ও সফল ক্যারিয়ার গঠনের বই।', `sort_order` = 5 WHERE `slug` = 'self-development';
UPDATE `categories` SET `name` = 'ইতিহাস', `description` = 'বিশ্ব ও বাংলার ঐতিহ্যের প্রামাণ্য ইতিহাস।', `sort_order` = 6 WHERE `slug` = 'history';
UPDATE `categories` SET `name` = 'মুক্তিযুদ্ধ', `description` = 'একাত্তরের বীরত্বগাথা ও গৌরবোজ্জ্বল অধ্যায়।', `sort_order` = 7 WHERE `slug` = 'liberation-war';
UPDATE `categories` SET `name` = 'পেশাগত/ক্যারিয়ার', `description` = 'কর্মক্ষেত্রে দক্ষতা ও নেতৃত্ব অর্জনের নির্দেশিকা।', `sort_order` = 8 WHERE `slug` = 'career';
UPDATE `categories` SET `name` = 'শিশু ও কিশোর', `description` = 'শিশুদের মেধা ও নৈতিকতা বিকাশের বই।', `sort_order` = 9 WHERE `slug` = 'children';
UPDATE `categories` SET `name` = 'অন্যান্য', `description` = 'বিবিধ চিন্তাশীল সাহিত্য ও গবেষণামূলক বই।', `sort_order` = 10 WHERE `slug` = 'other';

-- ৪. ৯টি বইয়ের তথ্য, মূল্য, বিবরণ ও প্রিভিউ
UPDATE `books` SET `title` = 'আলোর পথ', `author_name` = 'মুক্তাদা', `summary` = 'সত্য, সুন্দর ও আত্মশুদ্ধির আলোকিত জীবন গড়ার এক অনন্য জীবনমুখী গ্রন্থ।', `story_behind` = 'জীবনের কঠিন সময়ে আত্মিক প্রশান্তির সন্ধান করতে গিয়ে হৃদয়ের গভীর উপলব্ধি থেকেই এই বইটি রচিত হয়।', `publication_year` = '২০২৪', `page_count` = 240, `price_hardcopy` = 350.00, `price_ebook` = 220.00, `discount_percent` = 15.00, `cover_image` = 'covers/alor-poth.png', `is_featured` = 1, `is_latest` = 1, `is_popular` = 1, `is_upcoming` = 0, `preview_pages` = 3, `video_url` = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'alor-poth';
UPDATE `books` SET `title` = 'ইসলামের জীবন ও আদর্শ', `author_name` = 'মুক্তাদা', `summary` = 'দৈনন্দিন জীবনে ইসলামের শ্বাশত আদর্শ ও নৈতিকতার বাস্তব প্রয়োগ।', `story_behind` = 'আধুনিক যুবসমাজের নৈতিক সংকট মোকাবিলায় সহজ ভাষায় দ্বীনি মূল্যবোধ তুলে ধরার তাগিদ থেকে এ গ্রন্থের জন্ম।', `publication_year` = '২০২৩', `page_count` = 280, `price_hardcopy` = 400.00, `price_ebook` = 250.00, `discount_percent` = 10.00, `cover_image` = 'covers/islamer-pothe.png', `is_featured` = 1, `is_latest` = 1, `is_popular` = 1, `is_upcoming` = 0, `preview_pages` = 4, `video_url` = NULL, `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'islamer-jibon';
UPDATE `books` SET `title` = 'সুন্দর জীবনের পথে', `author_name` = 'মুক্তাদা', `summary` = 'হতাশা কাটিয়ে জীবনে ইতিবাচক দৃষ্টিভঙ্গি ও আশাবাদ জাগিয়ে তোলার শক্তিশালী উপন্যাস।', `story_behind` = 'বাস্তব জীবনের তিনটি সত্য ঘটনা অবলম্বনে চরিত্রগুলো গড়ে তোলা হয়েছে।', `publication_year` = '২০২৪', `page_count` = 310, `price_hardcopy` = 450.00, `price_ebook` = 280.00, `discount_percent` = 0.00, `cover_image` = 'covers/sundor-jibon.png', `is_featured` = 1, `is_latest` = 1, `is_popular` = 1, `is_upcoming` = 0, `preview_pages` = 3, `video_url` = NULL, `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'sundor-jibon';
UPDATE `books` SET `title` = 'দুনিয়ার জীবন ও আখিরাত', `author_name` = 'মুক্তাদা', `summary` = 'ক্ষণস্থায়ী পৃথিবীর মায়া আর চিরস্থায়ী আখিরাতের প্রস্তুতি নিয়ে গভীর আত্মবিশ্লেষণ।', `story_behind` = 'মৃত্যুচিন্তা ও আখিরাতের জবাবদিহিতা কীভাবে মানুষের দুনিয়ার জীবনকে সুন্দর করে, তা দেখাতেই বইটি লেখা।', `publication_year` = '২০২৩', `page_count` = 190, `price_hardcopy` = 300.00, `price_ebook` = 190.00, `discount_percent` = 5.00, `cover_image` = 'covers/duniyar-jibon.png', `is_featured` = 0, `is_latest` = 1, `is_popular` = 1, `is_upcoming` = 0, `preview_pages` = 3, `video_url` = NULL, `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'duniyar-jibon';
UPDATE `books` SET `title` = 'জীবনের রূপান্তর', `author_name` = 'মুক্তাদা', `summary` = 'খারাপ অভ্যাস পরিত্যাগ ও নিজের ভেতরের সম্ভাবনাকে জাগিয়ে তোলার রূপরেখা।', `story_behind` = 'পাঠকদের শত শত চিঠি ও মানসিক হতাশার প্রশ্নের জবাব হিসেবে এই বইটি সুবিন্যস্ত করা হয়েছে।', `publication_year` = '২০২৪', `page_count` = 220, `price_hardcopy` = 380.00, `price_ebook` = 240.00, `discount_percent` = 10.00, `cover_image` = 'covers/jibone-rupantor.png', `is_featured` = 1, `is_latest` = 1, `is_popular` = 1, `is_upcoming` = 0, `preview_pages` = 5, `video_url` = NULL, `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'jibone-rupantor';
UPDATE `books` SET `title` = 'সাহাবীদের জীবনকথা', `author_name` = 'মুক্তাদা', `summary` = 'রাসূলুল্লাহ (সা.)-এর সাহাবাদের ত্যাগ, সততা ও আত্মত্যাগের অমর গাথা।', `story_behind` = 'তরুণ প্রজন্মের জন্য নির্ভরযোগ্য সূত্রে সাহাবিদের বীরত্ব ও চরিত্র রূপায়ণ করার প্রয়াস।', `publication_year` = '২০২২', `page_count` = 350, `price_hardcopy` = 500.00, `price_ebook` = 300.00, `discount_percent` = 20.00, `cover_image` = 'covers/sahabider-jibon.png', `is_featured` = 0, `is_latest` = 0, `is_popular` = 1, `is_upcoming` = 0, `preview_pages` = 3, `video_url` = NULL, `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'sahabider-jibon';
UPDATE `books` SET `title` = 'খুশির পথে', `author_name` = 'মুক্তাদা', `summary` = 'হৃদয়ের সত্যিকারের প্রশান্তি ও সুখের ঠিকানা পাওয়ার আধ্যাত্মিক যাত্রা।', `story_behind` = 'পার্থিব প্রাচুর্যের মাঝেও কেন মানুষ অশান্তিতে থাকে—সেই মূল কারণ অনুসন্ধান করতে গিয়ে বইটি রচিত হয়।', `publication_year` = '২০২৪', `page_count` = 200, `price_hardcopy` = 320.00, `price_ebook` = 200.00, `discount_percent` = 0.00, `cover_image` = 'covers/khushir-pothe.png', `is_featured` = 1, `is_latest` = 1, `is_popular` = 0, `is_upcoming` = 0, `preview_pages` = 3, `video_url` = NULL, `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'khushir-pothe';
UPDATE `books` SET `title` = 'নবীজির জীবন ও কর্ম', `author_name` = 'মুক্তাদা', `summary` = 'বিশ্বনবীর জীবনের প্রতিটি অধ্যায় থেকে আধুনিক মানুষের জন্য শিক্ষা ও দিকনির্দেশনা।', `story_behind` = 'প্রেম ও ভক্তির সাথে সমকালীন জীবনের প্রতিটি সমস্যার নববী সমাধানের এক অপূর্ব সমন্বয়।', `publication_year` = '২০২৩', `page_count` = 420, `price_hardcopy` = 600.00, `price_ebook` = 350.00, `discount_percent` = 15.00, `cover_image` = 'covers/nobijir-jibon.png', `is_featured` = 1, `is_latest` = 0, `is_popular` = 1, `is_upcoming` = 0, `preview_pages` = 5, `video_url` = NULL, `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'nobijir-jibon';
UPDATE `books` SET `title` = 'প্রজ্ঞার আলো (আসন্ন বই)', `author_name` = 'মুক্তাদা', `summary` = 'জীবন, সমাজ ও মহাকালের গভীর দার্শনিক চিন্তা ও প্রজ্ঞার সমাহার।', `story_behind` = 'লেখক বর্তমানে এ বইটি চূড়ান্ত সম্পাদনায় ব্যস্ত আছেন।', `publication_year` = '২০২৫', `page_count` = 260, `price_hardcopy` = 450.00, `price_ebook` = 280.00, `discount_percent` = 0.00, `cover_image` = 'covers/alor-poth.png', `is_featured` = 0, `is_latest` = 0, `is_popular` = 0, `is_upcoming` = 1, `preview_pages` = 2, `video_url` = NULL, `is_published` = 1, `approval_status` = 'approved' WHERE `slug` = 'projnar-alo';

-- ৫. বিকৃত রিভিউ/টেস্টিমোনিয়াল সম্পূর্ণ মুছে খাঁটি বাংলায় রিপ্লেস
DELETE FROM `reviews` WHERE 1=1;
INSERT INTO `reviews` (`book_id`, `customer_name`, `comment`, `rating`, `status`, `is_verified_purchase`, `created_at`, `updated_at`) VALUES
((SELECT `id` FROM `books` WHERE `slug` = 'alor-poth' LIMIT 1), 'আব্দুর রহমান', 'অসাধারণ একটি বই! প্রতিটি পাতায় মনের খোরাক পেয়েছি। লেখকের লেখার ধরণ খুবই সাবলীল ও হৃদয়স্পর্শী। বইটি পড়ে জীবনের প্রতি দৃষ্টিভঙ্গি বদলে গেছে।', 5, 'approved', 1, NOW(), NOW()),
((SELECT `id` FROM `books` WHERE `slug` = 'islamer-jibon' LIMIT 1), 'তানভীর হাসান', 'দৈনন্দিন জীবনের প্রতিটি বিষয়ের এত চমৎকার ও যুক্তিগ্রাহ্য ব্যাখ্যা সচরাচর দেখা যায় না। তরুণ প্রজন্মের জন্য অবশ্য পাঠ্য একটি বই।', 5, 'approved', 1, NOW(), NOW()),
((SELECT `id` FROM `books` WHERE `slug` = 'sundor-jibon' LIMIT 1), 'ফারহানা ইয়াসমিন', 'হতাশা ও মানসিক অশান্তির সময়ে এই বইটি আমাকে নতুন করে বাঁচার স্বপ্ন দেখিয়েছে। প্রতিটি চরিত্র যেন জীবন্ত!', 5, 'approved', 1, NOW(), NOW()),
((SELECT `id` FROM `books` WHERE `slug` = 'duniyar-jibon' LIMIT 1), 'মোজাম্মেল হক', 'ক্ষণস্থায়ী পৃথিবীর মায়ার চেয়ে পরকালের প্রস্তুতি যে কতটা গুরুত্বপূর্ণ, তা লেখক অত্যন্ত আবেগময় ভাষায় ফুটিয়ে তুলেছেন।', 5, 'approved', 1, NOW(), NOW()),
((SELECT `id` FROM `books` WHERE `slug` = 'jibone-rupantor' LIMIT 1), 'মাহমুদুল করিম', 'ব্যক্তিত্ব বিকাশ এবং বদভ্যাস ত্যাগের সবচেয়ে কার্যকরী হ্যান্ডবুক। আমি আমার সব বন্ধুদের এই বইটি উপহার দিচ্ছি।', 5, 'approved', 1, NOW(), NOW());

-- ৬. মেম্বারশিপ টায়ার আপডেট
UPDATE `memberships` SET `title` = '১ বছর', `duration_months` = 12, `price` = 500.00, `discount_percent` = 10.00, `free_ebooks_count` = 1, `benefits` = 'সকল হার্ডকপিতে ১০% অতিরিক্ত ছাড়\n১টি ফ্রি প্রিমিয়াম ই-বুক\nনতুন বই প্রকাশে অগ্রাধিকার ডেলিভারি\nবিশেষ সদস্য অফার' WHERE `duration_months` = 12 OR `title` LIKE '%১ বছর%';
UPDATE `memberships` SET `title` = '২ বছর (সবচেয়ে জনপ্রিয়)', `duration_months` = 24, `price` = 900.00, `discount_percent` = 15.00, `free_ebooks_count` = 3, `benefits` = 'সকল হার্ডকপিতে ১৫% অতিরিক্ত ছাড়\n৩টি ফ্রি প্রিমিয়াম ই-বুক\nলেখকের স্বাক্ষরিত বিশেষ কপি উপহার\nপ্রি-অর্ডারে বিশেষ সুবিধা' WHERE `duration_months` = 24 OR `title` LIKE '%২ বছর%';
UPDATE `memberships` SET `title` = 'আজীবন', `duration_months` = 120, `price` = 2000.00, `discount_percent` = 25.00, `free_ebooks_count` = 10, `benefits` = 'আজীবন সকল বইয়ে ২৫% ভিআইপি ছাড়\nসকল নতুন ই-বুক স্বয়ংক্রিয়ভাবে ফ্রি\nলেখকের সাথে সরাসরি মতবিনিময় সেশনে আমন্ত্রণ\nবিশেষ ক্লাব প্রিভিলেজ' WHERE `duration_months` = 120 OR `title` LIKE '%আজীবন%';
