<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for author
        $admin = User::where('email', 'admin@gmail.com')->first();

        // Demo blog data
        $blogs = [
            [
                'title' => '5 Essential Tips for Building a Winning Resume in 2024',
                'slug' => 'essential-tips-for-building-winning-resume-2024',
                'excerpt' => 'Learn how to create a resume that stands out to recruiters and gets you more interview calls.',
                'content' => '<p>In today\'s competitive job market, having a standout resume is more important than ever. Here are 5 essential tips to help you create a winning resume:</p>
                
                <h2>1. Tailor Your Resume for Each Job</h2>
                <p>Customize your resume for every position you apply for. Use keywords from the job description and highlight relevant experience.</p>
                
                <h2>2. Quantify Your Achievements</h2>
                <p>Instead of just listing duties, show your impact with numbers. For example: "Increased sales by 30%" or "Reduced costs by 15%".</p>
                
                <h2>3. Keep it Clean and Professional</h2>
                <p>Use a clean, easy-to-read format. Stick to professional fonts like Arial or Calibri, and keep it to 1-2 pages maximum.</p>
                
                <h2>4. Include Relevant Skills</h2>
                <p>Highlight both technical and soft skills that are relevant to the position you\'re applying for.</p>
                
                <h2>5. Proofread Multiple Times</h2>
                <p>Spelling and grammar errors can instantly disqualify you. Have someone else review your resume before sending it out.</p>',
                'author_id' => $admin->id,
                'author_name' => 'Admin',
                'category' => 'Career Tips',
                'tags' => ['resume', 'career', 'job-search', 'professional'],
                'is_published' => true,
                'is_featured' => true,
                'views' => 156,
                'meta_title' => 'Resume Building Tips for 2024 | Job Portal',
                'meta_description' => 'Learn 5 essential tips for creating a winning resume that stands out to recruiters and gets you more interview calls in 2024.',
                'meta_keywords' => 'resume tips, career advice, job search, professional resume',
                'published_at' => now()->subDays(3),
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(3),
            ],
            [
                'title' => 'Ace Your Next Job Interview: Common Questions & Best Answers',
                'slug' => 'ace-your-next-job-interview-questions-answers',
                'excerpt' => 'Prepare for success with our guide to the most common interview questions and expert-approved answers.',
                'content' => '<p>Job interviews can be nerve-wracking, but proper preparation can make all the difference. Here\'s your comprehensive guide to acing your next interview:</p>
                
                <h2>Most Common Interview Questions</h2>
                
                <h3>1. "Tell me about yourself"</h3>
                <p><strong>Best Approach:</strong> Give a 60-90 second summary focusing on your professional background and what makes you a great fit for this specific role.</p>
                
                <h3>2. "Why do you want to work here?"</h3>
                <p><strong>Best Approach:</strong> Show you\'ve done your research. Mention specific things about the company that appeal to you and align with your career goals.</p>
                
                <h3>3. "What is your greatest weakness?"</h3>
                <p><strong>Best Approach:</strong> Choose a real weakness you\'ve been working on. Show self-awareness and your commitment to improvement.</p>
                
                <h3>4. "Where do you see yourself in 5 years?"</h3>
                <p><strong>Best Approach:</strong> Focus on growing with the company and developing skills that will make you more valuable in your role.</p>
                
                <h3>5. "Why should we hire you?"</h3>
                <p><strong>Best Approach:</strong> This is your chance to sell yourself. Connect your skills and experience directly to the company\'s needs.</p>
                
                <h2>Interview Preparation Tips</h2>
                <ul>
                    <li>Research the company thoroughly</li>
                    <li>Practice your answers out loud</li>
                    <li>Prepare questions to ask the interviewer</li>
                    <li>Dress professionally</li>
                    <li>Arrive 10-15 minutes early</li>
                </ul>',
                'author_id' => $admin->id,
                'author_name' => 'Admin',
                'category' => 'Interviews',
                'tags' => ['interview', 'job', 'career', 'preparation'],
                'is_published' => true,
                'is_featured' => true,
                'views' => 89,
                'meta_title' => 'Job Interview Questions and Answers Guide | Career Tips',
                'meta_description' => 'Learn how to answer common interview questions and prepare effectively for your next job interview with expert tips and strategies.',
                'meta_keywords' => 'interview questions, job interview, career tips, interview preparation',
                'published_at' => now()->subDays(7),
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(7),
            ],
            [
                'title' => 'The Ultimate Guide to Succeeding in Remote Work Environments',
                'slug' => 'ultimate-guide-to-succeeding-in-remote-work',
                'excerpt' => 'Master the skills and habits needed to excel in remote work settings and maintain work-life balance.',
                'content' => '<p>Remote work has become increasingly common, but succeeding in a remote environment requires specific skills and strategies. Here\'s your complete guide:</p>
                
                <h2>Essential Remote Work Skills</h2>
                
                <h3>1. Self-Motivation and Discipline</h3>
                <p>Working from home requires strong self-discipline. Create a routine and stick to it, just like you would in an office.</p>
                
                <h3>2. Communication Skills</h3>
                <p>Clear, concise communication is crucial when you\'re not in the same physical space. Over-communicate rather than under-communicate.</p>
                
                <h3>3. Time Management</h3>
                <p>Use tools and techniques like time blocking, Pomodoro technique, or digital calendars to stay organized and productive.</p>
                
                <h3>4. Tech Savviness</h3>
                <p>Become proficient with collaboration tools like Zoom, Slack, Microsoft Teams, Google Workspace, and project management software.</p>
                
                <h2>Setting Up Your Remote Workspace</h2>
                
                <h3>1. Dedicated Workspace</h3>
                <p>Create a specific area for work that\'s separate from your living space. This helps mentally separate work from personal life.</p>
                
                <h3>2. Ergonomic Setup</h3>
                <p>Invest in a good chair, proper desk height, and adequate lighting to prevent physical strain.</p>
                
                <h3>3. Reliable Technology</h3>
                <p>Ensure you have a fast, reliable internet connection and backup options for when technology fails.</p>
                
                <h2>Maintaining Work-Life Balance</h2>
                <ul>
                    <li>Set clear boundaries for work hours</li>
                    <li>Take regular breaks throughout the day</li>
                    <li>Create end-of-day rituals to signal work is done</li>
                    <li>Make time for social interaction (virtual or in-person)</li>
                    <li>Prioritize physical activity and movement</li>
                </ul>',
                'author_id' => $admin->id,
                'author_name' => 'Admin',
                'category' => 'Remote Work',
                'tags' => ['remote work', 'work from home', 'digital nomad', 'productivity'],
                'is_published' => true,
                'is_featured' => true,
                'views' => 124,
                'meta_title' => 'Remote Work Success Guide: Tips for Working from Home',
                'meta_description' => 'Learn essential skills, tools, and habits for succeeding in remote work environments and maintaining work-life balance.',
                'meta_keywords' => 'remote work, work from home, productivity, virtual office',
                'published_at' => now()->subDays(10),
                'created_at' => now()->subDays(11),
                'updated_at' => now()->subDays(10),
            ],
            [
                'title' => 'How to Negotiate Your Salary Like a Pro',
                'slug' => 'how-to-negotiate-your-salary-like-pro',
                'excerpt' => 'Learn proven strategies for salary negotiation that can increase your earnings significantly.',
                'content' => '<p>Salary negotiation is a crucial skill that can significantly impact your lifetime earnings. Here\'s how to do it effectively:</p>
                
                <h2>Preparation is Key</h2>
                <p>Research industry standards, company salary ranges, and your market value before entering any negotiation.</p>
                
                <h2>Timing Matters</h2>
                <p>Choose the right moment - usually after you\'ve received an offer but before you accept it.</p>
                
                <h2>Focus on Value</h2>
                <p>Frame your request around the value you bring to the company, not just what you want or need.</p>
                
                <h2>Practice Your Pitch</h2>
                <p>Rehearse your talking points so you can present them confidently and professionally.</p>',
                'author_id' => $admin->id,
                'author_name' => 'Admin',
                'category' => 'Career Tips',
                'tags' => ['salary', 'negotiation', 'career', 'compensation'],
                'is_published' => true,
                'is_featured' => false,
                'views' => 67,
                'meta_title' => 'Salary Negotiation Tips: How to Get Paid What You\'re Worth',
                'meta_description' => 'Learn professional salary negotiation strategies to increase your earnings and get paid what you deserve.',
                'meta_keywords' => 'salary negotiation, career growth, compensation, job offer',
                'published_at' => now()->subDays(15),
                'created_at' => now()->subDays(16),
                'updated_at' => now()->subDays(15),
            ],
            [
                'title' => 'The Future of Work: Top 10 In-Demand Skills for 2025',
                'slug' => 'future-of-work-top-in-demand-skills-2025',
                'excerpt' => 'Discover the skills that will be most valuable in the job market of tomorrow.',
                'content' => '<p>The job market is evolving rapidly. Here are the top skills that will be in high demand in 2025:</p>
                
                <ol>
                    <li><strong>AI and Machine Learning:</strong> Understanding of AI tools and applications</li>
                    <li><strong>Data Analysis:</strong> Ability to interpret and work with data</li>
                    <li><strong>Digital Marketing:</strong> Skills in online customer acquisition</li>
                    <li><strong>Cybersecurity:</strong> Protecting digital assets and information</li>
                    <li><strong>Cloud Computing:</strong> Working with cloud platforms and services</li>
                    <li><strong>Emotional Intelligence:</strong> Understanding and managing emotions</li>
                    <li><strong>Adaptability:</strong> Ability to learn and adjust quickly</li>
                    <li><strong>Creative Problem Solving:</strong> Innovative approaches to challenges</li>
                    <li><strong>Collaboration Tools:</strong> Proficiency with digital collaboration</li>
                    <li><strong>Sustainability Knowledge:</strong> Understanding of green practices</li>
                </ol>
                
                <p>Start developing these skills now to future-proof your career.</p>',
                'author_id' => $admin->id,
                'author_name' => 'Admin',
                'category' => 'Industry News',
                'tags' => ['future skills', 'career development', 'technology', 'trends'],
                'is_published' => true,
                'is_featured' => true,
                'views' => 98,
                'meta_title' => 'Future Skills: Top 10 In-Demand Job Skills for 2025',
                'meta_description' => 'Discover the most valuable skills for the future job market and learn how to develop them for career success.',
                'meta_keywords' => 'future skills, career development, job market trends, in-demand skills',
                'published_at' => now()->subDays(20),
                'created_at' => now()->subDays(21),
                'updated_at' => now()->subDays(20),
            ],
            [
                'title' => 'Building a Personal Brand for Career Advancement',
                'slug' => 'building-personal-brand-for-career-advancement',
                'excerpt' => 'Learn how to create a strong personal brand that opens doors to new opportunities.',
                'content' => '<p>A strong personal brand can accelerate your career growth. Here\'s how to build one:</p>
                
                <h2>Define Your Unique Value Proposition</h2>
                <p>What makes you different? Identify your unique strengths, skills, and perspectives.</p>
                
                <h2>Create Consistent Online Presence</h2>
                <p>Use platforms like LinkedIn, Twitter, and professional blogs to share your expertise.</p>
                
                <h2>Network Strategically</h2>
                <p>Build genuine relationships with people in your industry, both online and offline.</p>
                
                <h2>Share Your Knowledge</h2>
                <p>Write articles, give talks, or create content that demonstrates your expertise.</p>
                
                <h2>Get Recommendations and Testimonials</h2>
                <p>Collect endorsements from colleagues, managers, and clients who can vouch for your work.</p>',
                'author_id' => $admin->id,
                'author_name' => 'Admin',
                'category' => 'Career Tips',
                'tags' => ['personal brand', 'networking', 'career growth', 'professional'],
                'is_published' => true,
                'is_featured' => false,
                'views' => 54,
                'meta_title' => 'Personal Branding Guide for Career Success',
                'meta_description' => 'Learn how to build a strong personal brand that helps you stand out and advance your career.',
                'meta_keywords' => 'personal branding, career advancement, professional development, networking',
                'published_at' => now()->subDays(25),
                'created_at' => now()->subDays(26),
                'updated_at' => now()->subDays(25),
            ],
        ];

        // Insert blog posts
        foreach ($blogs as $blogData) {
            Blog::create($blogData);
        }

        $this->command->info('Demo blog posts created successfully!');
    }
}