
<x-app-layout>
    <div class="fixed-banner"></div>
    <div class="banner-category container-fluid" data-banner="fixed">
        <img src="{{asset('images/question.webp')}}" alt="questions" class="banner-category__img fr-fic fr-dii">
        <div class="banner-category__box-title">
            <h1 class="banner-category__title">QUESTIONS</h1>
        </div>
    </div>
    <div class="static-page__container">
        <h2 class="text-center mb-5">Frequently Asked Questions</h2>
        <div class="mb-4">
            <h3>1. How do I create an account and start an order?</h3>
            <p> Please use this guide: <a class="font-bold" href="{{asset('/pdf/How-to-create-a-new-account.pdf')}}" target="_bank" >How-to-create-a-new-account.pdf</a></p>
        </div>

        <div class="mb-4">
            <h3 >2. What kind of orders can I make?</h3>
            <p> Direct and Suscription. Direct orders are one-time orders, charged immediately. Subsctiptions are recurring deliveries that will occur at the specified frequency during normal delivery days, these are charged immediately at first and then a day before scheduled delivery from then on. Bulk orders: Can be delivered or picked up in-store with a week's notice. If you are a business seeking wholesale prices, please check question 6.</p>
        </div>

        <div class="mb-4">
            <h3>3. How can I edit/cancel my subscription?</h3>
            <p> Navigate to our home page -> Log in -> “Subscriptions” (left-hand side) You can edit/modify your delivery date. Under “Subscriptions” there is a “See & Edit” option that will allow you to change the frequency of your subscription (weekly, every 2 or 3 weeks). Unfortunately, we do not currently have the option to edit products in a subscription, so if you want to make changes or add products, you will have to cancel your current subscription and start a new one. *Reminder: You will be charged at that moment for new subscriptions created. You cancel an order by logging in and navigating to “Subscriptions,” you should see a red “cancel” button. To ensure you do not continue to get charged you should cancel your order at least 1 day before your scheduled payment date.</p>
        </div>

        <div class="mb-4">
            <h3>4. Can I pause my subscription?</h3>
            <p> Yes, you can. Under the “Subscriptions” there is a “Suspend” option for each active subscription. Once selected your subscription will be paused and you should see an “activate” option appear in green. Please pause subscriptions at least one day before the scheduled payment to avoid additional charges.</p>
        </div>
        <div class="mb-4">
            <h3>5. When and where are deliveries made</h3>
            <p>Due to limited demand and personnel, we are currently only making deliveries on Mondays and Tuesdays and only offering deliveries to the Castle Rock area.</p>
        </div>
        <div class="mb-4">
            <h3>6. When am I charged?</h3>
            <p>When you first subscribe you will be charged immediately, but the delivery will not be made until the scheduled date. For ongoing subscriptions, you will be charged 1-2 days before your delivery.</p>
        </div>
        <div class="mb-4">
            <h3>7. Wholesaler?</h3>
            <p>If you are a wholesaler hoping to explore our wholesale prices you can create an account and select “business” account. Once you have submitted your info you will have to wait for approval before you can log in and see our wholesale prices. You can contact us for expedited support.</p>
        </div>
    </div>
    @push('seo')
		<title>{{$seo['title']}}</title>
        <meta name="description" content="{{$seo['description']}}">
		<meta name="keywords" content="{{$seo['keywords']}}">
		<meta property="og:image" itemprop="image" content="{{$seo['image']}}" />
	@endpush
</x-app-layout>