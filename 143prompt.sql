-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2025 at 10:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prompt`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Web Development', 'web-development', 'General web development prompts covering full-stack development', 'bi-code-slash', 1, 1, '2025-10-12 15:09:47', '2025-10-12 15:09:47'),
(3, 'Frontend Prompt Generate', 'frontend-prompt-generate', 'Frontend-specific prompts for UI/UX and client-side development', 'bi-window', 2, 1, '2025-10-12 15:10:11', '2025-10-12 15:10:11'),
(4, 'Backend Dashboard Prompt Generate', 'backend-dashboard-prompt-generate', 'Backend development and admin dashboard prompts', 'bi-server', 3, 1, '2025-10-12 15:10:37', '2025-10-12 15:10:37'),
(5, 'Blog', 'blog', 'Blog content creation and article writing prompts', 'bi-journal-text', 4, 1, '2025-10-12 15:11:37', '2025-10-12 15:11:37'),
(6, 'SEO Friendly Prompt Generate', 'seo-friendly-prompt-generate', 'SEO-optimized content generation prompts', 'bi-search', 5, 1, '2025-10-12 15:12:04', '2025-10-12 15:12:35'),
(7, 'Content for Social Media', 'content-for-social-media', 'General social media content creation', 'bi-share', 6, 1, '2025-10-12 15:13:05', '2025-10-12 15:13:05'),
(8, 'Facebook viral post', 'facebook-viral-post', 'Facebook-specific viral content prompts', 'bi-facebook', 7, 1, '2025-10-12 15:13:31', '2025-10-12 15:13:31'),
(9, 'Instagram viral post', 'instagram-viral-post', 'Instagram engagement and viral content', 'bi-instagram', 8, 1, '2025-10-12 15:14:01', '2025-10-12 15:14:01'),
(10, 'YouTube script', 'youtube-script', 'YouTube video script writing prompts', 'bi-youtube', 9, 1, '2025-10-12 15:14:45', '2025-10-12 15:14:45'),
(11, 'Image prompts', 'image-prompts', 'AI image generation prompt optimization', 'bi-image', 10, 1, '2025-10-12 15:15:16', '2025-10-12 15:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_prompts`
--

CREATE TABLE `image_prompts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `original_description` text DEFAULT NULL,
  `optimized_prompt` longtext NOT NULL,
  `style` varchar(255) NOT NULL DEFAULT 'realistic',
  `aspect_ratio` varchar(255) NOT NULL DEFAULT '1:1',
  `mood` varchar(255) DEFAULT NULL,
  `lighting` varchar(255) DEFAULT NULL,
  `color_paletter` varchar(255) DEFAULT NULL,
  `quality_level` varchar(255) NOT NULL DEFAULT 'standard',
  `copies_count` int(11) NOT NULL DEFAULT 0,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image_prompts`
--

INSERT INTO `image_prompts` (`id`, `user_id`, `category_id`, `title`, `original_description`, `optimized_prompt`, `style`, `aspect_ratio`, `mood`, `lighting`, `color_paletter`, `quality_level`, `copies_count`, `views_count`, `is_public`, `created_at`, `updated_at`) VALUES
(1, 2, 11, 'A cat sitting on a windowsill', 'A fluffy orange tabby cat sitting on a sunlit windowsill, looking outside at birds, soft natural lighting', '### Optimized Prompt for AI Image Generation\n\n**Prompt:**  \n\"Create a highly detailed, realistic digital painting of a fluffy orange tabby cat sitting gracefully on a sunlit windowsill. The cat is gazing outside with a calm and curious expression, observing a small flock of birds perched on nearby branches. The scene is bathed in soft, golden natural lighting, evoking the warmth of a late afternoon. The mood is peaceful and serene, with a focus on capturing the quiet beauty of the moment. The color palette is vibrant, emphasizing the rich orange tones of the cat\'s fur, the warm hues of the sunlight, and the lush greens and earthy browns of the outdoor scenery. The windowsill is made of weathered wood with subtle textures, and faint reflections of light dance on the glass pane. Ensure intricate details in the cat\'s fur, with each strand visible, and realistic feather textures on the birds. The composition is framed in a 16:9 aspect ratio, with the cat positioned slightly off-center to create a balanced and dynamic visual. Render the image in high-definition (HD) quality, with sharp clarity, photorealistic textures, and no artifacts. Add subtle depth of field, with a soft focus on the background to emphasize the cat as the focal point. Avoid overly saturated colors or harsh contrasts; maintain a natural and harmonious aesthetic.\"\n\n**Additional Notes for Clarity (Not Part of the Prompt):**  \n- The prompt is structured to provide clear artistic direction (realistic style, peaceful mood), specific visual elements (cat, birds, windowsill), and technical requirements (16:9 aspect ratio, HD quality).  \n- It includes detailed descriptions of lighting, color, and textures to guide the AI in generating a cohesive and visually appealing image.  \n- Constraints like avoiding harsh contrasts ensure the output aligns with the intended serene mood.  \n\nThis optimized prompt is ready to be used directly in an AI image generator, ensuring the best possible output by minimizing ambiguity and maximizing descriptive precision.', 'realistic', '16:9', 'peaceful', 'golden', 'vibrant', 'hd', 0, 25, 1, '2025-10-30 16:16:20', '2025-10-31 12:20:39'),
(2, 2, 11, 'football World Cup', 'single man at the center of a football field during a World Cup', 'Below, I’ve transformed the basic image description into a highly detailed, professional, and optimized prompt for AI image generation. I’ve incorporated all the provided parameters, added specific artistic and technical details, and structured it for clarity and effectiveness while maintaining the original intent.\n\n---\n\n### Optimized Prompt for AI Image Generation\n\n**Prompt:**  \n\"A highly detailed, realistic depiction of a single man standing confidently at the center of a sprawling football field during a World Cup match. The man, dressed in a vibrant team jersey with intricate details (e.g., sweat stains, grass marks), exudes determination and focus, captured in a dramatic pose—perhaps with one hand on his chest and eyes looking upward, symbolizing hope or victory. The expansive stadium around him is packed with a roaring crowd in the background, their colorful banners and flags adding to the vibrant color palette of greens, blues, and bursts of team colors like red and yellow. The scene is bathed in golden-hour lighting, with warm, soft sunlight casting long shadows across the field and creating a glowing, cinematic effect. The mood is intensely dramatic, evoking the tension and passion of a pivotal World Cup moment. The grass on the field is meticulously detailed, showing wear and tear from the game, with scattered dirt and scuff marks. The sky above is a gradient of deep orange and pink, enhancing the emotional impact. Render this image in a 16:9 aspect ratio, with ultra-high-definition (HD) quality, ensuring sharp textures, realistic skin tones, and lifelike lighting effects. Emphasize photorealism with attention to fine details like individual crowd faces, fabric creases, and atmospheric depth. Use a wide-angle perspective to capture the vastness of the stadium and the isolation of the man at the center. Avoid any blur or low-resolution artifacts; prioritize crisp, professional-grade output suitable for large-scale display.\"\n\n**Additional Parameters (if supported by the AI tool):**  \n- **Style:** Photorealistic, cinematic  \n- **Aspect Ratio:** 16:9  \n- **Resolution:** 4K or higher  \n- **Negative Prompt (elements to avoid):** No cartoonish elements, no unrealistic proportions, no overexposure, no empty stadium, no irrelevant objects (e.g., random animals or unrelated props)  \n- **Artistic Direction:** Inspired by dramatic sports photography, akin to iconic World Cup imagery with a focus on emotional storytelling through light and composition.\n\n---\n\n### Why This Prompt is Optimized\n1. **Clarity and Specificity:** The prompt provides a vivid, detailed description of the scene (e.g., the man’s pose, jersey details, crowd, and field condition) to guide the AI toward a precise output.  \n2. **Context and Constraints:** It includes the World Cup setting, emotional tone (dramatic), and specific lighting (golden-hour) to anchor the mood and atmosphere.  \n3. **Technical Details:** Incorporating aspect ratio (16:9), HD quality, and photorealistic style ensures the output meets professional standards.  \n4. **Artistic Direction:** References to sports photography and cinematic composition help the AI understand the desired aesthetic.  \n5. **Negative Prompt:** Explicitly avoiding unwanted elements (e.g., cartoonish style, empty stadium) reduces the risk of irrelevant or low-quality results.  \n6. **Structured Format:** The prompt is broken into descriptive components (subject, environment, lighting, mood) for easy processing by the AI tool.\n\nThis optimized prompt is ready to be used directly in an AI image generator like MidJourney, Stable Diffusion, or DALL·E, and it maximizes the likelihood of generating a high-quality, visually striking image that aligns with the original intent. If you have a specific AI tool in mind, I can further tailor the syntax or keywords to match its requirements.', 'realistic', '16:9', 'Dramatic', 'golden', 'vibrant', 'hd', 0, 3, 1, '2025-10-31 12:25:34', '2025-10-31 14:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_12_185110_create_categories_table', 2),
(5, '2025_10_14_185940_create_subscriptions_table', 3),
(6, '2025_10_17_182331_create_prompts_table', 4),
(7, '2025_10_22_195419_create_notifications_table', 5),
(8, '2025_10_23_213242_create_prompt_templates_table', 6),
(9, '2025_10_24_210144_create_user_template_variations_table', 7),
(10, '2025_10_29_200132_create_image_prompts_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('c99247bd-9d57-4ff4-9430-67a3b5a770e8', 'App\\Notifications\\SubscriptionStatusNotification', 'App\\Models\\User', 2, '{\"subscription_id\":1,\"plan\":\"9.99\",\"status\":\"approved\"}', '2025-10-23 13:54:20', '2025-10-22 15:06:23', '2025-10-23 13:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prompts`
--

CREATE TABLE `prompts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `raw_prompt` text NOT NULL,
  `optimized_prompt` longtext DEFAULT NULL,
  `language` enum('english','spanish','french','german','chinese','japanese','hindi','bengali') NOT NULL DEFAULT 'english',
  `output_format` enum('text','json') NOT NULL DEFAULT 'text',
  `views_count` int(11) NOT NULL DEFAULT 0,
  `copies_count` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prompts`
--

INSERT INTO `prompts` (`id`, `user_id`, `category_id`, `title`, `raw_prompt`, `optimized_prompt`, `language`, `output_format`, `views_count`, `copies_count`, `is_featured`, `is_approved`, `is_public`, `created_at`, `updated_at`) VALUES
(2, 2, 10, 'Challenge-Style YouTube Script', 'You are an expert in challenge-style scripts for YouTube. I want to create a programming video that’s entertaining and easy to follow.  Ask me about rules, the time limit, any participants, and how I’ll frame the outcome.', 'Below is an optimized version of your prompt, transformed into a detailed, professional, and actionable request that ensures clarity, structure, and effectiveness for creating a challenge-style YouTube script about programming. I\'ve preserved the original intent while enhancing specificity, context, and guidance for the AI to deliver a high-quality response.\n\n---\n\n### Optimized Prompt: Challenge-Style YouTube Script for a Programming Video\n\n**Objective:**  \nI am seeking assistance in creating a highly engaging, entertaining, and easy-to-follow YouTube script for a challenge-style programming video. The goal is to captivate my audience with a fun, competitive, or creative programming task while ensuring the content is educational and accessible to viewers with varying levels of coding experience (e.g., beginners to intermediate). As an expert in crafting challenge-style scripts for YouTube, your role is to help me design a well-structured video script that includes an intro, body, conclusion, engagement hooks, and a strong call-to-action (CTA).\n\n**Video Format and Structure:**  \nPlease structure the script using the following format:  \n1. **Intro (30-60 seconds):**  \n   - Start with a high-energy hook to grab attention immediately (e.g., a surprising fact, bold statement, or teaser of the challenge).  \n   - Briefly introduce myself (the host) and the purpose of the video.  \n   - Clearly state the programming challenge, its rules, and why it’s exciting or relevant to the audience.  \n2. **Body (5-8 minutes):**  \n   - Break down the challenge into clear stages or steps (e.g., planning, coding, testing, or debugging).  \n   - Include entertaining commentary, humor, or relatable struggles to keep the tone light and engaging.  \n   - Provide educational insights or tips about the programming concepts involved, ensuring beginners can follow along.  \n   - If applicable, showcase progress, failures, or unexpected twists to build suspense or excitement.  \n3. **Conclusion (1-2 minutes):**  \n   - Reveal the outcome of the challenge (success, failure, or partial completion).  \n   - Reflect on key lessons learned or takeaways for the audience.  \n   - Highlight how viewers can apply what they’ve learned or try the challenge themselves.  \n4. **Engagement Hooks:**  \n   - Sprinkle interactive questions or prompts throughout the video to encourage comments (e.g., “What would you do differently?” or “Have you tried this before?”).  \n   - Add moments of suspense or curiosity to keep viewers watching (e.g., “Will I finish this in time? Stick around to find out!”).  \n5. **Call-to-Action (CTA):**  \n   - End with a clear and compelling CTA, encouraging viewers to like, subscribe, comment with their own challenge results, or watch a related video.  \n   - Suggest a way for viewers to participate (e.g., share their code or attempt the challenge themselves).\n\n**Context and Constraints:**  \n- **Target Audience:** Primarily beginner to intermediate programmers, aged 18-35, who enjoy learning through fun, practical challenges on YouTube.  \n- **Video Length:** Aim for a total runtime of 8-10 minutes to maintain viewer retention.  \n- **Tone:** Energetic, friendly, and motivational with a mix of humor and education. Avoid overly technical jargon unless explained clearly.  \n- **Platform Requirements:** The script must be optimized for YouTube, with attention to pacing, audience engagement, and retention strategies (e.g., avoiding long silences or slow sections).  \n- **No copyrighted material:** Ensure any examples or references are original or royalty-free to avoid issues with YouTube’s policies.\n\n**Specific Questions for Customization:**  \nTo tailor the script to my vision, please ask me the following details (if not provided, offer placeholder suggestions based on popular programming challenges):  \n1. **Challenge Rules:** What specific programming task or problem will the challenge focus on? (e.g., building a simple game, solving a coding puzzle, creating a web app feature.)  \n2. **Time Limit:** Is there a time constraint for completing the challenge? If so, what is it? (e.g., 24 hours, 1 hour live coding.)  \n3. **Participants:** Will this be a solo challenge, or will there be other participants/collaborators? If others are involved, how many, and what are their roles? (e.g., competing against friends, teaming up.)  \n4. **Outcome Framing:** How do I want to present the results of the challenge? (e.g., as a win/loss, a learning experience, a funny fail, or an invitation for viewers to improve on my solution.)  \n5. **Programming Language/Tools:** Which language or tools should the challenge focus on? (e.g., Python, JavaScript, specific frameworks or IDEs.)  \n6. **Additional Elements:** Are there any specific themes, props, or storytelling elements I’d like to include to make the video unique? (e.g., a themed costume, a storyline behind the challenge.)\n\n**Example for Inspiration (if needed):**  \nFor reference, consider a script inspired by popular YouTube programming challenges like “Can I Build a Calculator in 1 Hour Using Python?” The intro teases the difficulty of the task, the body shows the coding process with funny mistakes and quick explanations of key concepts (like loops or user input), and the conclusion reveals whether the calculator works while encouraging viewers to try it themselves.\n\n**Deliverable:**  \nPlease provide a detailed script outline or full script (depending on my preference after answering the customization questions) that adheres to the structure and guidelines above. Ensure the script is ready to record with natural, conversational language and clear cues for visuals or edits (e.g., “Show code on screen here” or “Cut to a funny reaction clip”). If you have additional suggestions for enhancing engagement or adding a unique twist to the challenge, please include them as optional notes.\n\n**Final Note:**  \nIf I haven’t provided answers to the customization questions yet, please respond with the list of questions above to gather the necessary details before drafting the script. If I’ve already provided some details, incorporate them into the script while asking for clarification on any missing pieces.\n\n---\n\n### Explanation of Improvements:\n1. **Clarity and Specificity:** The optimized prompt clearly defines the video format, target audience, tone, and structure, ensuring the AI understands the exact deliverable.  \n2. **Context and Constraints:** Added details about audience demographics, video length, platform requirements, and tone to guide the AI in creating relevant content.  \n3. **Actionable Guidance:** The prompt breaks down each section of the video (intro, body, conclusion, hooks, CTA) with specific instructions on content and pacing.  \n4. **Customization:** By including targeted questions, the prompt ensures the script is tailored to your vision while offering placeholder ideas if details are missing.  \n5. **Engagement Focus:** Emphasis on hooks, interactive elements, and CTAs aligns with YouTube best practices for viewer retention and growth.  \n6. **Professional Tone:** The language is formal yet approachable, making it easy for the AI to respond with a polished script.\n\nThis optimized prompt should yield a high-quality, engaging YouTube script tailored to your programming challenge idea. If you have additional details or preferences, feel free to provide them when using this prompt with an AI tool.', 'english', 'text', 7, 5, 0, 1, 1, '2025-10-18 15:52:39', '2025-10-31 12:29:58'),
(3, 2, 10, 'YouTube Video Campaign Planner', 'You are an expert Google Ads marketing specialist. I’d like to run a video campaign on YouTube to promote my Ai. Please ask me about the key points I want to highlight in my video, my target viewer profile, and any existing subscriber base I have on YouTube. Also confirm how I plan to track video engagement and whether I’m interested in remarketing to viewers who watch a certain percentage.', 'नमस्ते! मैं आपके मूल प्रॉम्प्ट को एक अधिक प्रभावी, विस्तृत और पेशेवर प्रॉम्प्ट में बदलने जा रहा हूँ, जो YouTube वीडियो स्क्रिप्ट और Google Ads कैंपेन के लिए अनुकूलित होगा। नीचे दिया गया ऑप्टिमाइज़्ड प्रॉम्प्ट स्पष्ट, संरचित और कार्यान्वयन योग्य है, जिसमें सभी आवश्यक दिशानिर्देशों का पालन किया गया है।\n\n---\n\n### ऑप्टिमाइज़्ड प्रॉम्प्ट (हिंदी में):\n\n**प्रॉम्प्ट का शीर्षक: YouTube वीडियो कैंपेन स्क्रिप्ट और Google Ads रणनीति तैयार करना**\n\n**प्रिय Google Ads विपणन विशेषज्ञ,**\n\nमैं अपने AI उत्पाद/सेवा को बढ़ावा देने के लिए एक प्रभावी YouTube वीडियो कैंपेन चलाना चाहता हूँ। मैं चाहता हूँ कि आप मुझे एक संरचित वीडियो स्क्रिप्ट तैयार करने में मदद करें, जिसमें इंट्रो, मुख्य भाग, निष्कर्ष, दर्शकों को जोड़े रखने के लिए हुक, और एक मजबूत कॉल-टू-एक्शन (CTA) शामिल हो। इसके साथ ही, Google Ads के माध्यम से इस कैंपेन को चलाने के लिए रणनीतिक सुझाव भी प्रदान करें। नीचे मेरे कैंपेन के लिए आवश्यक जानकारी और संदर्भ दिए गए हैं। कृपया इन बिंदुओं पर आधारित अपनी सिफारिशें और स्क्रिप्ट तैयार करें, और यदि आवश्यक हो तो अतिरिक्त प्रश्न पूछें।\n\n**1. कैंपेन का उद्देश्य और संदर्भ:**\n- मैं अपने AI उत्पाद/सेवा को प्रचारित करना चाहता हूँ, जो [संक्षेप में उत्पाद/सेवा का विवरण, जैसे \"छोटे व्यवसायों के लिए स्वचालित ग्राहक सहायता प्रदान करता है\"] है।\n- इस वीडियो का मुख्य उद्देश्य [उदाहरण: ब्रांड जागरूकता बढ़ाना, लीड जनरेट करना, या सीधे बिक्री बढ़ाना] है।\n- वीडियो की अवधि [उदाहरण: 30 सेकंड का स्किपेबल विज्ञापन या 2-3 मिनट का गैर-स्किपेबल कंटेंट] होनी चाहिए।\n\n**2. वीडियो स्क्रिप्ट के लिए मुख्य बिंदु (मुझे इन पर विस्तार से पूछें):**\n- मेरे AI उत्पाद/सेवा की मुख्य विशेषताएँ या लाभ जिन्हें मैं हाइलाइट करना चाहता हूँ। (उदाहरण: समय की बचत, लागत-प्रभावी, उपयोग में आसान)\n- मेरे उत्पाद की विशिष्टता (USP) जो इसे प्रतिस्पर्धियों से अलग बनाती है।\n- कोई विशेष ऑफर, छूट, या सीमित समय की डील जो मैं दर्शकों को देना चाहता हूँ।\n\n**3. लक्षित दर्शक प्रोफाइल (मुझे इनके बारे में विस्तार से पूछें):**\n- मेरे लक्षित दर्शकों की आयु, लिंग, स्थान, रुचियाँ, और व्यवसाय/उद्योग।\n- दर्शकों की मुख्य समस्या या आवश्यकता जिसे मेरा AI हल करता है।\n- दर्शकों की भाषा और सांस्कृतिक प्राथमिकताएँ (उदाहरण: हिंदी/अंग्रेजी, क्षेत्रीय संदर्भ)।\n\n**4. मेरे मौजूदा YouTube दर्शक आधार (मुझे इस बारे में पूछें):**\n- क्या मेरे पास पहले से एक YouTube चैनल है? यदि हाँ, तो मेरे सब्सक्राइबर्स की संख्या और उनकी रुचियाँ।\n- क्या मैं अपने मौजूदा दर्शकों को इस कैंपेन में शामिल करना चाहता हूँ, या केवल नए दर्शकों पर ध्यान देना चाहता हूँ?\n\n**5. वीडियो एंगेजमेंट ट्रैकिंग और रीमार्केटिंग (मुझे इस पर स्पष्टता के लिए पूछें):**\n- मैं वीडियो एंगेजमेंट को कैसे ट्रैक करना चाहता हूँ? (उदाहरण: व्यूज़, वॉच टाइम, क्लिक-थ्रू रेट, या कन्वर्शन)\n- क्या मैं उन दर्शकों को रीमार्केट करना चाहता हूँ जिन्होंने वीडियो का एक निश्चित प्रतिशत (जैसे 50% या 75%) देखा है? यदि हाँ, तो रीमार्केटिंग के लिए मेरी रणनीति या लक्ष्य क्या है?\n- क्या मैं Google Ads के साथ अन्य ट्रैकिंग टूल (जैसे Google Analytics) को एकीकृत करना चाहता हूँ?\n\n**6. वीडियो स्क्रिप्ट की संरचना (कृपया इसे ध्यान में रखें):**\n- **इंट्रो (पहले 5-10 सेकंड):** एक आकर्षक हुक जो दर्शकों का ध्यान तुरंत खींचे (उदाहरण: एक सवाल, चौंकाने वाला तथ्य, या समस्या का उल्लेख)।\n- **मुख्य भाग:** मेरे AI उत्पाद/सेवा की मुख्य विशेषताओं और लाभों को संक्षेप में समझाएँ, जिसमें विश्वसनीयता बढ़ाने के लिए केस स्टडी, प्रशंसापत्र, या आँकड़े शामिल हों (यदि लागू हो)।\n- **निष्कर्ष और CTA:** एक स्पष्ट और मजबूत कॉल-टू-एक्शन, जैसे वेबसाइट पर जाना, फ्री ट्रायल के लिए साइन अप करना, या अधिक जानकारी के लिए संपर्क करना। साथ ही, यदि कोई ऑफर है तो उसे दोहराएँ।\n- **एंगेजमेंट हुक:** दर्शकों को कमेंट करने, लाइक करने, या चैनल को सब्सक्राइब करने के लिए प्रोत्साहित करें।\n\n**7. Google Ads कैंपेन रणनीति (कृपया सुझाव दें):**\n- मेरे लक्षित दर्शकों तक पहुँचने के लिए सबसे उपयुक्त विज्ञापन प्रारूप (जैसे स्किपेबल इन-स्ट्रीम, नॉन-स्किपेबल, बम्पर विज्ञापन)।\n- बजट आवंटन और बोली रणनीति (जैसे CPM, CPV) के लिए सिफारिशें।\n- कीवर्ड, डेमोग्राफिक्स, और रुचि-आधारित लक्ष्यीकरण के लिए सुझाव।\n\n**8. अतिरिक्त नोट्स और बाधाएँ:**\n- मेरा बजट [राशि या सीमा, यदि लागू हो] है।\n- मेरे पास पहले से कोई क्रिएटिव एसेट्स (जैसे लोगो, वीडियो क्लिप्स, या वॉयसओवर) हैं या नहीं।\n- क्या कोई विशिष्ट ब्रांड टोन (जैसे पेशेवर, दोस्ताना, हास्यपूर्ण) है जिसे मुझे बनाए रखना चाहिए?\n\n**अनुरोध:**\nकृपया उपरोक्त बिंदुओं पर आधारित एक विस्तृत YouTube वीडियो स्क्रिप्ट ड्राफ्ट करें और Google Ads कैंपेन के लिए रणनीतिक सुझाव प्रदान करें। यदि मेरे द्वारा दी गई जानकारी अधूरी है, तो कृपया मुझे विशिष्ट प्रश्न पूछकर स्पष्टता प्राप्त करें। मैं चाहता हूँ कि वीडियो दर्शकों को आकर्षित करे, मेरे AI उत्पाद/सेवा की मुख्य विशेषताओं को प्रभावी ढंग से हाइलाइट करे, और अधिकतम कन्वर्शन के लिए एक मजबूत CTA शामिल करे।\n\n**धन्यवाद!**\n\n---\n\n### इस प्रॉम्प्ट को ऑप्टिमाइज़ करने के पीछे का कारण:\n1. **स्पष्टता और संरचना:** मूल प्रॉम्प्ट में केवल कुछ बुनियादी प्रश्न थे, जबकि इस ऑप्टिमाइज़्ड प्रॉम्प्ट में सभी पहलुओं (स्क्रिप्ट संरचना, लक्षित दर्शक, ट्रैकिंग, रणनीति) को विस्तार से शामिल किया गया है।\n2. **संदर्भ और बाधाएँ:** बजट, ब्रांड टोन, और मौजूदा संसाधनों जैसे पहलुओं को शामिल करके, यह सुनिश्चित किया गया है कि प्रतिक्रिया अधिक प्रासंगिक और कार्यान्वयन योग्य हो।\n3. **उदाहरण और मार्गदर्शन:** स्क्रिप्ट सं', 'hindi', 'text', 2, 0, 0, 1, 1, '2025-10-19 14:44:28', '2025-10-31 12:15:42');

-- --------------------------------------------------------

--
-- Table structure for table `prompt_templates`
--

CREATE TABLE `prompt_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `template_content` text DEFAULT NULL,
  `placeholders` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`placeholders`)),
  `example_output` text DEFAULT NULL,
  `difficulty_level` varchar(255) NOT NULL DEFAULT 'beginner',
  `icon` varchar(255) DEFAULT NULL,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prompt_templates`
--

INSERT INTO `prompt_templates` (`id`, `category_id`, `name`, `slug`, `description`, `template_content`, `placeholders`, `example_output`, `difficulty_level`, `icon`, `usage_count`, `is_active`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES
(1, 5, 'Blog Post Generator', 'blog-post-generator', 'Create engaging blog posts on any topic with customizable tone and style.', 'Write a comprehensive {word_count} word blog post about {topic} for {target_audience}. The tone should be {tone} and include {key_points}. Make it SEO-friendly and engaging.', '[{\"key\":\"word_count\",\"label\":\"Word Count\",\"type\":\"text\",\"placeholder\":\"e.g., 1500\",\"required\":true},{\"key\":\"topic\",\"label\":\"Topic\",\"type\":\"text\",\"placeholder\":\"Main topic of your blog post\",\"required\":true},{\"key\":\"target_audience\",\"label\":\"Target Audience\",\"type\":\"text\",\"placeholder\":\"e.g., small business owners\",\"required\":true},{\"key\":\"tone\",\"label\":\"Tone\",\"type\":\"text\",\"placeholder\":\"e.g., professional, casual, friendly\",\"required\":true},{\"key\":\"key_points\",\"label\":\"Key Points\",\"type\":\"textarea\",\"placeholder\":\"List main points to cover\",\"required\":true}]', 'Write a comprehensive 1500 word blog post about Email Marketing for small business owners. The tone should be friendly and practical and include tips on list building, email design, automation, and measuring success. Make it SEO-friendly and engaging.', 'beginner', 'ri-article-line', 0, 1, 0, 0, '2025-10-23 16:10:16', '2025-10-25 16:14:27'),
(2, 7, 'Social Media Caption Creator', 'social-media-caption-creator', 'Generate catchy social media captions with hashtags and call-to-actions.', 'Create {number} engaging {platform} captions about {topic} for {brand_voice} brand. Include {hashtag_count} relevant hashtags and a clear call-to-action.', '[{\"key\":\"number\",\"label\":\"Number of Captions\",\"type\":\"text\",\"placeholder\":\"e.g., 5\",\"required\":true},{\"key\":\"platform\",\"label\":\"Platform\",\"type\":\"text\",\"placeholder\":\"Instagram, Facebook, LinkedIn\",\"required\":true},{\"key\":\"topic\",\"label\":\"Topic\",\"type\":\"text\",\"placeholder\":\"What is the post about?\",\"required\":true},{\"key\":\"brand_voice\",\"label\":\"Brand Voice\",\"type\":\"text\",\"placeholder\":\"e.g., professional, fun, inspiring\",\"required\":true},{\"key\":\"hashtag_count\",\"label\":\"Number of Hashtags\",\"type\":\"text\",\"placeholder\":\"e.g., 5-10\",\"required\":true}]', 'Create 5 engaging Instagram captions about sustainable fashion for eco-conscious brand. Include 8 relevant hashtags and a clear call-to-action.', 'beginner', 'ri-chat-3-line', 0, 1, 1, 0, '2025-10-23 16:10:16', '2025-10-25 16:09:44'),
(3, 6, 'Product Description Writer', 'product-description-writer', 'Write compelling product descriptions that sell and rank well in search engines.', 'Write a compelling {word_count} word product description for {product_name} - {product_type}. Target audience is {target_customer}. Highlight {key_features} and include {seo_keywords} for SEO. Focus on benefits over features.', '[{\"key\":\"word_count\",\"label\":\"Word Count\",\"type\":\"text\",\"placeholder\":\"e.g., 200\",\"required\":true},{\"key\":\"product_name\",\"label\":\"Product Name\",\"type\":\"text\",\"placeholder\":\"Name of the product\",\"required\":true},{\"key\":\"product_type\",\"label\":\"Product Type\",\"type\":\"text\",\"placeholder\":\"e.g., wireless headphones\",\"required\":true},{\"key\":\"target_customer\",\"label\":\"Target Customer\",\"type\":\"text\",\"placeholder\":\"Who is buying this?\",\"required\":true},{\"key\":\"key_features\",\"label\":\"Key Features\",\"type\":\"textarea\",\"placeholder\":\"List main features\",\"required\":true},{\"key\":\"seo_keywords\",\"label\":\"SEO Keywords\",\"type\":\"text\",\"placeholder\":\"Keywords to include\",\"required\":true}]', 'Write a compelling 200 word product description for AirPods Pro - wireless earbuds. Target audience is tech-savvy millennials. Highlight noise cancellation, battery life, seamless Apple integration and include wireless earbuds, noise cancelling, Apple AirPods for SEO. Focus on benefits over features.', 'intermediate', 'ri-shopping-bag-line', 1, 1, 1, 0, '2025-10-23 16:10:16', '2025-10-28 14:38:28'),
(4, 10, '111YouTube Script Outline', '111youtube-script-outline', 'Create structured YouTube video scripts with intro, body, and outro.', 'Create a {duration} minute YouTube video script about {topic} for {audience}. Include an attention-grabbing intro, {main_points} main points in the body, and a strong call-to-action outro. Tone should be {tone}.', '[{\"key\":\"duration\",\"label\":\"Video Duration\",\"type\":\"text\",\"placeholder\":\"e.g., 10\",\"required\":true},{\"key\":\"topic\",\"label\":\"Video Topic\",\"type\":\"text\",\"placeholder\":\"Main topic\",\"required\":false},{\"key\":\"audience\",\"label\":\"Target Audience\",\"type\":\"text\",\"placeholder\":\"Who is watching?\",\"required\":false},{\"key\":\"main_points\",\"label\":\"Number of Main Points\",\"type\":\"text\",\"placeholder\":\"e.g., 5\",\"required\":false},{\"key\":\"tone\",\"label\":\"Tone\\/Style\",\"type\":\"text\",\"placeholder\":\"e.g., educational, entertaining\",\"required\":false},{\"key\":\"test\",\"label\":\"test\\/syle\",\"type\":\"text\",\"placeholder\":\"just test\",\"required\":false}]', 'Create a 10 minute YouTube video script about starting a podcast for aspiring content creators. Include an attention-grabbing intro, 5 main points in the body, and a strong call-to-action outro. Tone should be encouraging and practical.', 'beginner', 'ri-youtube-line', 0, 1, 1, 0, '2025-10-23 16:10:16', '2025-10-25 15:32:10'),
(5, 7, 'Email Marketing Campaign', 'email-marketing-campaign', 'Design complete email marketing campaigns with subject lines and body copy.', 'Create a {campaign_type} email campaign for {product_service} targeting {audience}. Include a compelling subject line (under {subject_length} characters), preview text, body copy with {tone} tone, and clear CTA. Goal: {campaign_goal}.', '[{\"key\":\"campaign_type\",\"label\":\"Campaign Type\",\"type\":\"text\",\"placeholder\":\"e.g., promotional, newsletter, welcome\",\"required\":true},{\"key\":\"product_service\",\"label\":\"Product\\/Service\",\"type\":\"text\",\"placeholder\":\"What are you promoting?\",\"required\":true},{\"key\":\"audience\",\"label\":\"Target Audience\",\"type\":\"text\",\"placeholder\":\"Who receives this?\",\"required\":true},{\"key\":\"subject_length\",\"label\":\"Subject Line Length\",\"type\":\"text\",\"placeholder\":\"e.g., 50\",\"required\":true},{\"key\":\"tone\",\"label\":\"Tone\",\"type\":\"text\",\"placeholder\":\"e.g., professional, friendly\",\"required\":true},{\"key\":\"campaign_goal\",\"label\":\"Campaign Goal\",\"type\":\"text\",\"placeholder\":\"What action do you want?\",\"required\":true}]', 'Create a promotional email campaign for new software product targeting small business owners. Include a compelling subject line (under 50 characters), preview text, body copy with professional yet friendly tone, and clear CTA. Goal: drive free trial signups.', 'advanced', 'ri-mail-line', 0, 1, 0, 0, '2025-10-23 16:10:16', '2025-10-23 16:10:16'),
(6, 10, 'Tutorial & How-To Video Script', 'tutorial-how-to-video-script', 'Create step-by-step tutorial scripts that are easy to follow and engaging.', 'Create a {duration} minute YouTube tutorial script teaching viewers how to {skill_topic}. Target audience: {audience}. Include a friendly intro explaining what viewers will learn, list of {materials_needed} required tools/materials, {steps_count} clear step-by-step instructions with timestamps, common mistakes to avoid, troubleshooting tips, and outro with next steps or related tutorials. Visual cues: mention when to show close-ups, screen recordings, or graphics. Tone should be {tone}.', '[{\"key\":\"duration\",\"label\":\"Video Duration\",\"type\":\"text\",\"placeholder\":\"e.g., 12\",\"required\":true},{\"key\":\"skill_topic\",\"label\":\"Skill\\/Topic to Teach\",\"type\":\"text\",\"placeholder\":\"e.g., edit videos in CapCut\",\"required\":false},{\"key\":\"audience\",\"label\":\"Skill Level of Audience\",\"type\":\"text\",\"placeholder\":\"e.g., complete beginners, intermediate\",\"required\":false},{\"key\":\"materials_needed\",\"label\":\"Materials\\/Tools Needed\",\"type\":\"text\",\"placeholder\":\"e.g., laptop, software, smartphone\",\"required\":false},{\"key\":\"steps_count\",\"label\":\"Number of Main Steps\",\"type\":\"text\",\"placeholder\":\"e.g., 7\",\"required\":false},{\"key\":\"tone\",\"label\":\"Teaching Tone\",\"type\":\"text\",\"placeholder\":\"e.g., patient, encouraging, straightforward\",\"required\":false}]', 'Create a 12 minute YouTube tutorial script teaching viewers how to create animations in Canva. Target audience: complete beginners. Include a friendly intro explaining what viewers will learn, list of free Canva account and basic design knowledge required tools/materials, 7 clear step-by-step instructions with timestamps, common mistakes to avoid, troubleshooting tips, and outro with next steps or related tutorials. Visual cues: mention when to show close-ups, screen recordings, or graphics. Tone should be patient and encouraging.', 'intermediate', 'ri-file-text-line', 1, 1, 0, 1, '2025-10-26 13:14:53', '2025-10-29 12:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4ybFwPNHayQf3n5AKuLtqfI81rneUuGqJixeofQs', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWDV4d0NOUjBNTTF1aEczWTJ0VHRlMm5sOEFqbWRjT01wUVBGQjJXTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbWFnZS9wcm9tcHRzL3Nob3cvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1761864505),
('DeoVjzXO5QtCV2TqDzfvH7qvs08WNaVWNLWq2bH2', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHhFSTQxaVNVd0NtakZlbmpaQjE2VEhpZTJLVk9QeksxeHZMb2tMZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbWFnZS9wcm9tcHRzL2luZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1761775581),
('R5UDPU63Mr0ofd0wypUsh14PCCzD18jbSg8UkCYI', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYThRSnppY29VQ1phUDlmZGk1QkY0cnN1Njdsemo1TVV5VWVMNkFqbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbWFnZS9wcm9tcHRzL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1761853522),
('zDbd9X3tBcp06geQY6IMuZEHwMEKiI2kgbDRS0RD', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVTh0NzRTbUNwRnBGS2R6ZzM2bVRqRU9leUJLTzBlZjlQWDNaYXh0RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1761944256);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `plan` enum('free','pro','essential') NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` enum('bank_transfer','stripe') NOT NULL DEFAULT 'bank_transfer',
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_proof` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `plan`, `amount`, `payment_method`, `transaction_id`, `payment_proof`, `status`, `starts_at`, `ends_at`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 2, 'pro', 9.99, 'bank_transfer', '23232322323', 'payment_proofs/NKl4jsaP1IJAPKWUC0MwSu6CdDL9eljAwM4lsxni.png', 'approved', '2025-10-22 15:06:09', '2025-11-21 15:06:09', 'Approved by Admin', '2025-10-21 15:12:04', '2025-10-22 15:06:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` varchar(255) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `subscription_plan` enum('free','pro','essential') NOT NULL DEFAULT 'free',
  `prompts_used_this_month` int(11) NOT NULL DEFAULT 0,
  `subscription_renewed_at` timestamp NULL DEFAULT NULL,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `last_reset` timestamp NULL DEFAULT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `phone`, `address`, `role`, `status`, `remember_token`, `subscription_plan`, `prompts_used_this_month`, `subscription_renewed_at`, `usage_count`, `last_reset`, `is_banned`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$MHAuNM0urV1WybpnakkhbunGgwFunMN/.smYFxrUjFCaFUdF2KOue', '1760215535.jpg', '23232323', 'India Kolkata', 'admin', '1', NULL, 'free', 0, NULL, 0, NULL, 0, '2025-10-10 14:26:52', '2025-10-11 16:20:19'),
(2, 'User', 'user@gmail.com', NULL, '$2y$12$1lxOy3QzguveJwsrdrekPOPM3WM14lS2xWet9C7w2.wEwLdyoWTUy', '1760562758.jpg', '34343434', 'Uttara Dhaka', 'user', '1', NULL, 'pro', 4, '2025-10-22 15:06:09', 0, NULL, 0, '2025-10-10 14:28:06', '2025-10-31 12:25:34'),
(3, 'Khan', 'khan@gmail.com', NULL, '$2y$12$iwZMFX276ED/xI5eyb7Xve5Mgb9aopngqc5esp95fR1MflrQtpWxe', NULL, NULL, NULL, 'user', '1', NULL, 'free', 0, NULL, 0, NULL, 0, '2025-10-11 15:37:37', '2025-10-11 15:37:37'),
(4, 'Test User', 'test@example.com', '2025-10-23 16:10:17', '$2y$12$zV3eN9bcIHZjg829Bjl14.bHpU9c/kStDjYjTD/aZ4Ec/TwVuBgMm', NULL, NULL, NULL, 'user', '1', 'AUTFY9qzCN', 'free', 0, NULL, 0, NULL, 0, '2025-10-23 16:10:17', '2025-10-23 16:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_template_variations`
--

CREATE TABLE `user_template_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `template_id` bigint(20) UNSIGNED NOT NULL,
  `variation_name` varchar(255) NOT NULL,
  `filled_placeholders` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`filled_placeholders`)),
  `generated_prompt` text NOT NULL,
  `optimized_prompt` text DEFAULT NULL,
  `is_favorite` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_template_variations`
--

INSERT INTO `user_template_variations` (`id`, `user_id`, `template_id`, `variation_name`, `filled_placeholders`, `generated_prompt`, `optimized_prompt`, `is_favorite`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'My Product', '{\"word_count\":\"200\",\"product_name\":\"Worricow Wireless Bluetooth Headphone\",\"product_type\":\"Wireless Headphone\",\"target_customer\":\"Student\",\"key_features\":\"Color Black\\r\\nBluetooth\\r\\nBehind the Neck\",\"seo_keywords\":\"Wireless Headphone\"}', 'Write a compelling 200 word product description for Worricow Wireless Bluetooth Headphone - Wireless Headphone. Target audience is Student. Highlight Color Black\r\nBluetooth\r\nBehind the Neck and include Wireless Headphone for SEO. Focus on benefits over features.', 'Below is the optimized version of your prompt, transformed into a clear, detailed, and professional instruction set for generating an SEO-friendly product description. I\'ve incorporated guidelines for clarity, specificity, and search engine optimization while maintaining the original intent.\n\n---\n\n### Optimized Prompt: SEO-Friendly Product Description for Worricow Wireless Bluetooth Headphone\n\n**Objective:**  \nCreate a compelling, SEO-optimized 200-word product description for the \"Worricow Wireless Bluetooth Headphone - Wireless Headphone.\" The description should resonate with the target audience of students, emphasizing the benefits of the product over technical features.  \n\n**Target Audience:**  \nStudents (ages 13-25), who value affordability, style, comfort, and convenience for studying, online classes, gaming, and casual music listening.  \n\n**Key Focus Areas for Content:**  \n1. Highlight the benefits of the headphone’s design and functionality, such as comfort for long study sessions, freedom of movement, and immersive sound for focus or relaxation.  \n2. Emphasize specific attributes as benefits:  \n   - **Color: Black** – Showcase as sleek, stylish, and versatile for a modern student lifestyle.  \n   - **Bluetooth Connectivity** – Highlight wireless freedom and easy pairing with devices like laptops, tablets, and smartphones.  \n   - **Behind-the-Neck Design** – Stress comfort and a secure fit for active students during commutes or workouts.  \n3. Incorporate the primary keyword \"Wireless Headphone\" naturally at least 3-5 times for SEO purposes, ensuring it fits within the flow of the text.  \n\n**SEO Guidelines:**  \n- Include the primary keyword \"Wireless Headphone\" in the first sentence and sporadically throughout the description for keyword density (2-3%).  \n- Use related secondary keywords naturally, such as \"Bluetooth Wireless Headphone,\" \"Student Headphone,\" and \"Behind-the-Neck Headphone,\" to enhance search relevance.  \n- Write in a conversational yet persuasive tone to engage students, focusing on how the product solves their pain points (e.g., tangled wires, discomfort during long use).  \n- Craft a meta-description-friendly opening (first 1-2 sentences) that can be used for product listings or search snippets (under 160 characters). Example: \"Discover the Worricow Wireless Headphone – a stylish black Bluetooth headphone perfect for students with a comfy behind-the-neck design!\"  \n\n**Content Structure:**  \n1. **Opening Hook (30-40 words):** Grab attention with a relatable problem or desire for students (e.g., need for focus during study or convenience on the go) and introduce the Worricow Wireless Headphone as the solution.  \n2. **Benefits Section (100-120 words):** Detail the lifestyle benefits of the headphone, linking to the key attributes (Black color, Bluetooth, Behind-the-Neck design). Focus on emotional appeal and practical value for students.  \n3. **Closing Call-to-Action (30-40 words):** Encourage immediate action with a persuasive statement (e.g., \"Upgrade your study sessions with this must-have Wireless Headphone!\") and reinforce the product’s appeal.  \n\n**Constraints:**  \n- Keep the description concise at 200 words (±10 words).  \n- Avoid overly technical jargon or feature-heavy content; prioritize user benefits.  \n- Ensure the tone is youthful, relatable, and energetic to connect with students.  \n- Do not include pricing or promotional offers unless specified.  \n\n**Example for Inspiration (Not to be Copied):**  \n\"Struggling to focus during late-night study sessions? Meet the Worricow Wireless Headphone, the ultimate companion for students! Its sleek black design screams style, while the Bluetooth connectivity offers tangle-free listening on the go. The behind-the-neck fit ensures comfort for hours, whether you\'re cramming for exams or unwinding with music. Say goodbye to distractions and hello to immersive sound with this Wireless Headphone. Grab yours today and ace your day!\"  \n\n**Deliverable:**  \nProvide a 200-word product description that adheres to the above guidelines, is optimized for SEO with natural keyword integration, and appeals directly to students by focusing on benefits and lifestyle fit.  \n\n---\n\n### Explanation of Enhancements:\n1. **Clarity and Specificity:** The optimized prompt breaks down the task into clear objectives, audience details, and focus areas, ensuring the AI understands the exact tone and content priorities.  \n2. **SEO Focus:** Specific instructions for keyword usage, meta-description-friendly content, and related terms ensure the output is search-engine-friendly.  \n3. **Structured Guidance:** The content structure and word count allocation provide a roadmap for the AI to follow, reducing ambiguity.  \n4. **Context and Tone:** Detailed audience insights and tone specifications ensure the description resonates with students.  \n5. **Example Inclusion:** A sample snippet illustrates the desired style without dictating the exact output.  \n6. **Constraints:** Added boundaries prevent irrelevant or off-topic content, maintaining focus on benefits over features.  \n\nThis optimized prompt ensures the AI generates a high-quality, SEO-friendly product description tailored to the target audience while meeting modern content standards for search visibility.', 0, '2025-10-28 14:38:28', '2025-10-28 14:38:28'),
(2, 2, 6, 'How to get rich', '{\"duration\":\"1\",\"skill_topic\":\"How to get rich without luck\",\"audience\":\"beginner\",\"materials_needed\":\"AI Tools\",\"steps_count\":\"5\",\"tone\":\"soft\"}', 'Create a 1 minute YouTube tutorial script teaching viewers how to How to get rich without luck. Target audience: beginner. Include a friendly intro explaining what viewers will learn, list of AI Tools required tools/materials, 5 clear step-by-step instructions with timestamps, common mistakes to avoid, troubleshooting tips, and outro with next steps or related tutorials. Visual cues: mention when to show close-ups, screen recordings, or graphics. Tone should be soft.', 'Below is the optimized version of your prompt, transformed into a highly effective, detailed, and professional instruction for creating a YouTube script. I\'ve enhanced clarity, added context, structured it for actionable outcomes, and ensured the tone and intent are preserved while making it more specific and engaging for the target audience.\n\n---\n\n### Optimized Prompt: YouTube Tutorial Script for \"How to Get Rich Without Luck\"\n\n**Objective:**  \nWrite a concise, engaging 1-minute YouTube tutorial script titled \"How to Get Rich Without Luck\" aimed at beginners who are seeking actionable financial advice. The script must educate viewers on a simplified, ethical approach to building wealth without relying on chance, using a friendly, approachable tone to connect with the audience. The video should include a structured format with an intro, body, and outro, as well as visual cues, engagement hooks, and a call-to-action to maximize viewer retention and interaction.\n\n**Target Audience:**  \n- Beginners with little to no experience in personal finance or wealth-building strategies.  \n- Age range: 18-35, likely new to financial independence concepts.  \n- Viewers looking for quick, digestible, and practical advice in a short-form video format.\n\n**Tone and Style:**  \n- Soft, friendly, and encouraging to build trust and make complex ideas feel accessible.  \n- Avoid jargon or overly technical terms; explain concepts in simple, relatable language.  \n- Maintain an upbeat and motivational vibe to inspire action.\n\n**Video Length and Format:**  \n- Total runtime: 60 seconds (tight pacing is critical to fit content within this constraint).  \n- Structure the script with clear timestamps for each section to ensure pacing:  \n  - Intro: 0:00-0:10 (10 seconds)  \n  - Body (Tools & Steps): 0:10-0:45 (35 seconds)  \n  - Outro & Call-to-Action: 0:45-1:00 (15 seconds)\n\n**Script Components (Detailed Instructions):**  \n1. **Intro (0:00-0:10):**  \n   - Start with a warm greeting and a quick hook to grab attention (e.g., a surprising fact or question like, \"Want to build wealth without relying on luck?\").  \n   - Briefly state what viewers will learn (e.g., \"In just 1 minute, I’ll show you 5 simple steps to start building wealth today!\").  \n   - Visual Cue: Show the host smiling on camera or a bold graphic with the video title \"How to Get Rich Without Luck.\"  \n\n2. **Body (0:10-0:45):**  \n   - **Tools/Materials (0:10-0:15, ~5 seconds):**  \n     - Mention any required tools or resources (e.g., budgeting apps like Mint or YNAB, a notebook for goal-setting, or free online courses).  \n     - Keep it minimal and beginner-friendly; suggest free or low-cost options.  \n     - Visual Cue: Display app icons or a screenshot of a budgeting tool on-screen.  \n   - **Step-by-Step Instructions (0:15-0:40, ~25 seconds):**  \n     - Provide 5 clear, concise steps to build wealth without luck (e.g., 1. Set clear financial goals, 2. Create a budget, 3. Save consistently, 4. Learn a high-income skill, 5. Invest for the long term).  \n     - Allocate ~5 seconds per step; use simple language and one actionable tip per step.  \n     - Include timestamps for each step in the script (e.g., Step 1 at 0:15-0:20).  \n     - Visual Cue: Use on-screen text or graphics for each step (e.g., \"Step 1: Set Goals\") and show relevant visuals like a goal planner or savings chart. For steps involving apps or websites, include brief screen recordings.  \n   - **Common Mistakes & Troubleshooting (0:40-0:45, ~5 seconds):**  \n     - Highlight 1-2 common beginner mistakes (e.g., overspending or not having an emergency fund) and a quick fix (e.g., \"Track every dollar to avoid overspending!\").  \n     - Visual Cue: Show a quick \"X\" graphic over a mistake (e.g., a credit card bill) and a checkmark over the solution.\n\n3. **Outro & Engagement (0:45-1:00):**  \n   - Summarize the key takeaway (e.g., \"Start small, stay consistent, and wealth will follow!\").  \n   - Include a strong call-to-action (e.g., \"Like this video if you found it helpful, and subscribe for more money tips every week!\").  \n   - Suggest next steps or related content (e.g., \"Check out my video on budgeting for beginners in the link below!\").  \n   - Visual Cue: Show a subscribe button animation or a thumbnail of the related video on-screen.  \n\n**Additional Guidelines and Constraints:**  \n- Keep the script tight and conversational; aim for 120-150 words total to fit within 60 seconds (approx. 2-2.5 words per second).  \n- Avoid promising unrealistic results (e.g., \"Get rich quick\"); focus on sustainable, ethical strategies.  \n- Ensure visual cues are specific and tied to the script (e.g., \"Show a close-up of a budgeting app at 0:12\").  \n- Include at least one engagement hook in the intro or outro to encourage comments (e.g., \"Comment below: What’s your biggest money goal?\").  \n\n**Example Snippet (Intro):**  \n\"Hey everyone, want to build wealth without waiting for a lucky break? In just 1 minute, I’ll share 5 simple steps to start your journey today! Let’s dive in!\"  \n(Visual Cue: Bold text graphic saying \'5 Steps to Wealth\' at 0:05.)\n\n**Deliverable Format:**  \n- Provide the full script as a single, well-formatted document with clearly labeled sections (Intro, Body, Outro).  \n- Include timestamps for each section and visual cues in parentheses.  \n- Ensure the tone remains soft and friendly throughout, with motivational undertones.\n\n**Final Note:**  \nThe goal is to create a script that feels personal, actionable, and visually engaging while fitting within the strict 1-minute timeframe. Prioritize clarity and impact in every sentence to keep beginners inspired and motivated to take action.\n\n---\n\n### Why This Optimization Works:\n1. **Clarity and Specificity:** The revised prompt breaks down each section with exact timings, word counts, and visual instructions, ensuring the scriptwriter knows precisely what to include and when.  \n2. **Context for Audience:** Detailed audience profiling (age, experience level) helps tailor the content to beginners, avoiding overwhelm or irrelevance.  \n3. **Actionable Structure:** The timestamped format and specific components (e.g., engagement hooks, common mistakes) guide the writer to create a polished, professional script.  \n4. **Tone Preservation:** The soft, friendly tone is reinforced with examples and explicit instructions to maintain a motivational vibe.  \n5. **Visual and Engagement Focus:** Adding specific visual cues and engagement strategies ensures the video isn’t just informative but also interactive and dynamic.  \n\nThis optimized prompt provides a clear roadmap for the scriptwriter, ensuring the final output is concise, beginner-friendly, and optimized for YouTube’s short-form content style. If you have further refinements or specific focuses (e.g., a niche like \"online business wealth\"), I can adjust accordingly!', 1, '2025-10-29 12:50:18', '2025-10-29 13:10:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `image_prompts`
--
ALTER TABLE `image_prompts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_prompts_category_id_foreign` (`category_id`),
  ADD KEY `image_prompts_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `prompts`
--
ALTER TABLE `prompts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prompts_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `prompts_category_id_created_at_index` (`category_id`,`created_at`),
  ADD KEY `prompts_is_featured_is_approved_index` (`is_featured`,`is_approved`);

--
-- Indexes for table `prompt_templates`
--
ALTER TABLE `prompt_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prompt_templates_slug_unique` (`slug`),
  ADD KEY `prompt_templates_category_id_is_active_index` (`category_id`,`is_active`),
  ADD KEY `prompt_templates_is_featured_is_active_index` (`is_featured`,`is_active`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_template_variations`
--
ALTER TABLE `user_template_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_template_variations_template_id_foreign` (`template_id`),
  ADD KEY `user_template_variations_user_id_template_id_index` (`user_id`,`template_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_prompts`
--
ALTER TABLE `image_prompts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prompts`
--
ALTER TABLE `prompts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prompt_templates`
--
ALTER TABLE `prompt_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_template_variations`
--
ALTER TABLE `user_template_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `image_prompts`
--
ALTER TABLE `image_prompts`
  ADD CONSTRAINT `image_prompts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `image_prompts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prompts`
--
ALTER TABLE `prompts`
  ADD CONSTRAINT `prompts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prompts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prompt_templates`
--
ALTER TABLE `prompt_templates`
  ADD CONSTRAINT `prompt_templates_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_template_variations`
--
ALTER TABLE `user_template_variations`
  ADD CONSTRAINT `user_template_variations_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `prompt_templates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_template_variations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
