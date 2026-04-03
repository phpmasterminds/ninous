<!-- Welcome Section -->
<div class="welcome-section">
	<div class="welcome-container">
		<div class="welcome-row">
			<div class="welcome-image">
				<img src="{$aDetails.image_path}" alt="OrthodoxMatch illustration">
				<!--<div class="image-note">I need admincp control to change image</div>-->
			</div>
			
			<div class="welcome-content">
				<h1>{$aDetails.join_title}</h1>
				<p>{$aDetails.join_text_description}</p>
				
				<button class="btn-join">{$aDetails.join_button_text}</button>
				
				<!--<p class="action-note">When user clicks button for first time, open the app and start trial period.</p>-->
			</div>
		</div>
	</div>
</div>
{literal}
 <style>
       #page_dating_join .header-page-title{
		   display:none;
	   }
        .welcome-section {
            padding: 60px 20px;
            background-color: #ffffff;
        }

        .welcome-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .welcome-row {
            display: flex;
            align-items: center;
            gap: 60px;
        }

        .welcome-image {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .welcome-image img {
            max-width: 100%;
            height: auto;
        }

        .image-note {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 15px;
            font-weight: 500;
        }

        .annotation-arrow {
            position: absolute;
            width: 80px;
            height: 3px;
            background-color: #ff6b6b;
            transform: rotate(-30deg);
        }

        .annotation-arrow::after {
            content: '';
            position: absolute;
            right: -8px;
            top: -6px;
            width: 0;
            height: 0;
            border-left: 10px solid #ff6b6b;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
        }

        .welcome-content {
            flex: 1;
        }

        .welcome-content h1 {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .welcome-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 30px;
        }

        .btn-join {
            background-color: #ffc107;
            color: #333;
            font-weight: 600;
            font-size: 16px;
            padding: 12px 32px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .btn-join:hover {
            background-color: #ffb300;
            text-decoration: none;
            color: #333;
        }

        .btn-join::before {
            content: '+';
            font-size: 20px;
            font-weight: bold;
        }

        .action-note {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 25px;
            line-height: 1.5;
            max-width: 300px;
        }

        .questionnaire-section {
            padding: 80px 20px 60px;
            background-color: #f5f5f5;
        }

        .questionnaire-section h2 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 40px;
            color: #333;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .questionnaire-content {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 4px;
        }

        .questionnaire-item {
            margin-bottom: 30px;
        }

        .questionnaire-item h3 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .questionnaire-item p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .welcome-row {
                flex-direction: column;
                gap: 40px;
            }

            .welcome-image {
                order: 2;
            }

            .welcome-content {
                order: 1;
            }

            .welcome-content h1 {
                font-size: 28px;
            }

            .annotation-arrow {
                display: none;
            }

            .image-note {
                display: none;
            }

            .action-note {
                display: none;
            }

            .questionnaire-section {
                padding: 40px 20px;
            }

            .questionnaire-section h2 {
                font-size: 24px;
                margin-bottom: 30px;
            }

            .questionnaire-content {
                padding: 20px;
            }
        }
    </style>
{/literal}