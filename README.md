<h1 align="center">OpenMVM</h1>

<h3>Introduction</h3>

<p>OpenMVM is an open-source multi-vendor e-commerce marketplace platform.</p>

<p>It still lacks a lot of basic features. It is not ready for production yet.</p>

<h3>Current Features</h3>

<h4>Marketplace (front-end) features:</h4>
<ul>
	<li>Customer registration, login, edit profile, address book, view orders</li>
	<li>Seller registration, edit profile, add / edit product, view orders, shipping method configurations</li>
	<li>Multi language</li>
	<li>Multi currency</li>
	<li>Browse / search products</li>
	<li>One-page checkout</li>
	<li>Single store / Multi store checkout</li>
	<li>Payment methods (Bank Transfer, Cash on Delivery)</li>
	<li>Shipping methods (Flat Rate, Weight Based Shipping, Zone Based Shipping)</li>
	<li>Order totals (Sub Total, Shipping, Total)</li>
	<li>Reset password</li>
	<li>Product options / variants</li>
</ul>

<h4>Administrator (back-end) features:</h4>
<ul>
	<li>Add / edit / delete Categories</li>
	<li>Add / edit / delete Administrator groups</li>
	<li>Add / edit / delete Administrators</li>
	<li>Add / edit / delete Customer groups</li>
	<li>Add / edit / delete Customers</li>
	<li>Add / edit / delete Administrator area themes</li>
	<li>Add / edit / delete Marketplace themes</li>
	<li>Add / edit / delete Marketplace widgets</li>
	<li>Add / edit / delete Marketplace layouts</li>
	<li>Add / edit / delete Languages</li>
	<li>Add / edit / delete Currencies</li>
	<li>Add / edit / delete Countries</li>
	<li>Add / edit / delete Zones</li>
	<li>Add / edit / delete Geo zones</li>
	<li>Add / edit / delete Weight classes</li>
	<li>Add / edit / delete Length classes</li>
	<li>Add / edit / delete Order statuses</li>
	<li>Add / edit / delete Payment methods</li>
	<li>Add / edit / delete Shipping methods</li>
	<li>Add / edit / delete Order totals</li>
	<li>Add / edit / delete Plugins</li>
	<li>Image manager</li>
	<li>Add / edit / delete Pages</li>
	<li>Settings</li>
	<li>Error logs</li>
	<li>Language editor</li>
	<li>Demo manager</li>
</ul>

<h3>How to Install:</h3>

<p>OpenMVM is not ready for production. Use a local PHP development server such as: XAMPP, WampServer, EasyPHP, etc.</p>

<ol>
	<li>Rename env file to .env in both 'root' and 'public/install/'. Also, you may need to change the RewriteBase value in both 'public/.htaccess' and 'public/install/public/.htaccess'.</li>
	<li>Open the installer page by visiting your app URL</li>
	<li>Follow the installation steps</li>
	<li>Login to the Administrator area by visiting the admin url defined in the .env file: [app.baseURL]/[app.adminUrlSegment]. Use your administrator username and password</li>
	<li>Do not forget to delete the install folder 'public/install'</li>
</ol>

<h3>Demo Data</h3>

<p>You can download demo data here: https://github.com/openmvm/OpenMVM-Demo-Data</p>

<p>Install it from the Demo Manager page (login to administrator area -> Developer -> Demo Manager)</p>
