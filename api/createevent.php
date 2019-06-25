<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> | Howlik API Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="csrf-token" content="BuqTOq4oD63EyBst25h5bf5hFSW7IA7XB3Gql73k">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
			input[type=text], input[type=number], input[type=password], input[type=email], select, textarea, button {
				width: 30%;
				padding: 8px 16px;
				margin: 8px 0;
				box-sizing: border-box;
			}
			label > input[type=text], input[type=number] {
				width: 14.9% !important; 
			}
		</style>
	</head>
	<body>
		<form method="post" align="center" action="http://www.howlik.com/api/create/event/load" id="form">
			<h3>Event Create GET</h3> <br>
			</div>
			<input type="text" name="apikey" id="apikey" value="913361515646355" placeholder="API KEY" autocomplete="on" />
			<div>
				<br>
			</div>
			<input type="text" name="language_code" id="language_code" value="en" placeholder="LANGUAGE CODE" />
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="BuqTOq4oD63EyBst25h5bf5hFSW7IA7XB3Gql73k" />
			<button type="button" onclick="get()">Submit</button>
		</form>
		
		<br> <p align="center" id="output"></p> <br>
		
		<form method="post" align="center" action="http://www.howlik.com/api/create/event" enctype="multipart/form-data" id="form">
			<h3>Event Create POST</h3> <br>
			<input type="text" name="apikey" id="api_key" placeholder="API KEY" required readonly />
			<div>
				<br><br>
			</div>
			<input type="text" name="event_title" id="event_title" placeholder="EVENT TITLE" required />
			<div>
				<br>
			</div>
			<select id="event_type" name="event_type" required >
				<option value="">EVENT TYPE</option>
				<option value="1">Sports &amp; Outdoors</option>
				<option value="2">Concerts &amp; Festivals</option>
				<option value="3">Networking &amp; Meetups</option>
				<option value="4">Trade Shows &amp; Conventions</option>
				<option value="5">Training &amp; Seminars</option>
				<option value="6">Ceremonies</option>
				<option value="7">Conferences</option>
				<option value="8">Wedding</option>
				<option value="9">Birthday Party</option>
				<option value="10">Family Events</option>
				<option value="11">Nightlife</option>
				<option value="12">All others events</option>
				<option value="13">Marriage</option>
				<option value="33">Charity </option>
				<option value="34">Fashion show </option>
				<option value="35">Public Event </option>
				<option value="36">privet event </option>
				<option value="38">Ramadan </option>
				<option value="39">Holidays </option>
				<option value="40">Opening </option>
				<option value="41">New season </option>
			</select>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="start_date" id="start_date" placeholder="START DATE" value="2018-01-30 09:00:00" readonly /> 
				<input type="text" name="end_date" id="end_date" placeholder="END DATE" value="2018-01-31 18:00:00" readonly /> 
			</label>
			<div>
				<br>
			</div>
			<select name="country_code" id="country_code" onchange="generate(this.value)" required>
				<option value="">COUNTRY</option>
				<option value="BH"> Bahrain </option>
				<option value="IN"> India </option>
				<option value="KW"> Kuwait </option>
				<option value="OM"> Oman </option>
				<option value="QA"> Qatar </option>
				<option value="SA"> Saudi Arabia </option>
				<option value="AE"> United Arab Emirates </option>	
			</select>
			<div>
				<br>
			</div>
			<select name="city_code" id="city_code" required>
				<option value="">CITY</option>
				<option value="10770456">Abburu</option>
				<option value="1279414">Abdullapuram</option>
				<option value="11184109">Abrama</option>
				<option value="6988657">Abusar</option>
				<option value="1279390">Achalpur</option>
				<option value="10318248">Achhej</option>
				<option value="1279381">Achhota</option>
				<option value="8438330">Adamilli</option>
				<option value="10308103">Adamwal</option>
				<option value="10701879">Adarman</option>
				<option value="1279361">Adas</option>
				<option value="1463448">Adgaon</option>
				<option value="1279344">Adilabad</option>
				<option value="1279335">Adoni</option>
				<option value="6620216">Adugodi</option>
				<option value="10165958">Aduka</option>
				<option value="10773610">Adusumalli</option>
				<option value="1279311">Adyar</option>
				<option value="6990852">Agar</option>
				<option value="1279299">Agar</option>
				<option value="10854628">Agara</option>
				<option value="1279290">Agartala</option>
				<option value="10699253">Agewa</option>
				<option value="1279275">Aghapur</option>
				<option value="10194395">Aghiana</option>
				<option value="1279265">Agolai</option>
				<option value="1279259">Agra</option>
				<option value="1279241">Aharwan</option>
				<option value="10698078">Ahirka</option>
				<option value="6994409">Ahmadganj</option>
				<option value="1279225">Ahmadpur</option>
				<option value="1279227">Ahmadpur</option>
				<option value="1279233">Ahmedabad</option>
				<option value="1279228">Ahmednagar</option>
				<option value="1279217">Ahu</option>
				<option value="10696646">Ahulana</option>
				<option value="1279213">Ahwa</option>
				<option value="10768749">Aibhimavaram</option>
				<option value="7279599">Airoli</option>
				<option value="10181152">Aithal</option>
				<option value="1279186">Aizawl</option>
				<option value="10190419">Ajabpura</option>
				<option value="6989101">Ajitpura</option>
				<option value="1279159">Ajmer</option>
				<option value="11062113">Ajodhyapur</option>
				<option value="1279148">Akalgarh</option>
				<option value="10435235">Akata</option>
				<option value="6989588">Akbarpur</option>
				<option value="1279128">Akha</option>
				<option value="10702720">Akhara</option>
				<option value="10822638">Akhepura</option>
				<option value="10791444">Akkampeta</option>
				<option value="10786270">Akkayyapalem</option>
				<option value="1279105">Akola</option>
				<option value="10506658">Akoli</option>
				<option value="10672845">Akrampur</option>
				<option value="8442456">Akurdi</option>
				<option value="10877867">Alakode</option>
				<option value="10261609">Alamgir</option>
				<option value="1279069">Alanallur</option>
				<option value="1279066">Alandi</option>
				<option value="1279064">Alandur</option>
				<option value="1279063">Alandurai</option>
				<option value="1279058">Alangulam</option>
				<option value="10526630">Alanpur</option>
				<option value="1278985">Alappuzha</option>
				<option value="1279045">Aldona</option>
				<option value="1279027">Alibag</option>
				<option value="1279017">Aligarh</option>
				<option value="1465983">Alinjivakkam</option>
				<option value="1279005">Alipur</option>
				<option value="1279006">Alipur</option>
				<option value="11184121">Alkapuri</option>
				<option value="10729175">Allachaur</option>
				<option value="1278994">Allahabad</option>
				<option value="10434616">Allowal</option>
				<option value="1278974">Almora</option>
				<option value="1278952">Alur</option>
				<option value="7279600">Aluva</option>
				<option value="1278946">Alwar</option>
				<option value="1278935">Amalapuram</option>
				<option value="1278920">Amarapur</option>
				<option value="7667973">Amaravathy</option>
				<option value="8442000">Amaravila</option>
				<option value="6990954">Amarpur</option>
				<option value="1278895">Amarpur</option>
				<option value="1441979">Amarpura</option>
				<option value="1278891">Amarsar</option>
				<option value="10736369">Amarwasi</option>
				<option value="1278881">Amba</option>
				<option value="1278871">Ambad</option>
				<option value="1278868">Ambah</option>
				<option value="1278860">Ambala</option>
				<option value="1278858">Ambalapuzha</option>
				<option value="1278903">Ambarnath</option>
				<option value="10784559">Ambativalasa</option>
				<option value="1278840">Ambattur</option>
				<option value="1278837">Ambavli</option>
				<option value="1278833">Ambegaon</option>
				<option value="1278832">Ambelim</option>
				<option value="1278809">Amber</option>
				<option value="10692062">Ambewadi</option>
				<option value="1278829">Ambheti</option>
				<option value="1278827">Ambikapur</option>
				<option value="1278819">Amboli</option>
				<option value="1465586">Aminjikarai</option>
				<option value="1278758">Amloh</option>
				<option value="10788688">Ammulapalem</option>
				<option value="1278718">Amravati</option>
				<option value="1278715">Amreli</option>
				<option value="1278710">Amritsar</option>
				<option value="1278708">Amroha</option>
				<option value="1278707">Amroli</option>
				<option value="10854607">Amruthahalli</option>
				<option value="1444979">Amsaur</option>
				<option value="1348870">Amtala</option>
				<option value="1278701">Amtala</option>
				<option value="1278685">Anand</option>
				<option value="1278682">Anandnagar</option>
				<option value="1278678">Anandpur</option>
				<option value="1278672">Anantapur</option>
				<option value="1278667">Anantnag</option>
				<option value="10513644">Anbhora</option>
				<option value="1278654">Anchal</option>
				<option value="10316598">Andana</option>
				<option value="1278633">Andheri</option>
				<option value="10978512">Anegundi</option>
				<option value="1278609">Anekal</option>
				<option value="10846540">Anekallu</option>
				<option value="10975839">Angol</option>
				<option value="1278593">Angul</option>
				<option value="1278573">Anjar</option>
				<option value="1278566">Anjuna</option>
				<option value="1278553">Ankleshwar</option>
				<option value="1278546">Annamalainagar</option>
				<option value="1445195">Annaram</option>
				<option value="1278542">Annavaram</option>
				<option value="10770554">Anuru</option>
				<option value="10768783">Apparaopeta</option>
				<option value="10323028">Araghar</option>
				<option value="1278471">Arakkonam</option>
				<option value="1278466">Arambagh</option>
				<option value="1278465">Arambakkam</option>
				<option value="10228379">Arasalur</option>
				<option value="1278405">Ariyalur</option>
				<option value="10254663">Arjungarh</option>
				<option value="1278378">Arnauli</option>
				<option value="10628607">Aroor</option>
				<option value="1278359">Arpora</option>
				<option value="1278483">Arrah</option>
				<option value="10734295">Arsapur</option>
				<option value="1278340">Aruppukkottai</option>
				<option value="1278335">Arvi</option>
				<option value="1278334">Arwal</option>
				<option value="1278314">Asansol</option>
				<option value="1278297">Ashoknagar</option>
				<option value="10700273">Asoli</option>
				<option value="1278254">Assagao</option>
				<option value="10625885">Assi</option>
				<option value="1278248">Assolda</option>
				<option value="7002758">Asta</option>
				<option value="1278235">Asulkhar</option>
				<option value="10746640">Aterna</option>
				<option value="1278216">Athagarh</option>
				<option value="10930024">Athalur</option>
				<option value="1278201">Atmakur</option>
				<option value="1278181">Attibele</option>
				<option value="1278176">Attingal</option>
				<option value="1278173">Attur</option>
				<option value="9915006">Auchandi</option>
				<option value="1278163">Aundh</option>
				<option value="1278156">Aurad</option>
				<option value="1278149">Aurangabad</option>
				<option value="6620455">Auroville</option>
				<option value="1278130">Avadi</option>
				<option value="1278122">Avanigadda</option>
				<option value="10929778">Avilora</option>
				<option value="10530370">Awajpur</option>
				<option value="10930060">Ayilakkad</option>
				<option value="1278094">Ayodhya</option>
				<option value="1278090">Ayyampettai</option>
				<option value="1278085">Azadpur</option>
				<option value="1278083">Azamgarh</option>
				<option value="1253500">Azhikkal</option>
				<option value="10549543">Babail</option>
				<option value="1442254">Babarpur</option>
				<option value="10688656">Babhulvadi</option>
				<option value="11063009">Babnapur</option>
				<option value="1278028">Badabar</option>
				<option value="1278007">Badarpur</option>
				<option value="7279742">Baddi</option>
				<option value="10166392">Badheri</option>
				<option value="10734005">Badheri</option>
				<option value="1277977">Badkulla</option>
				<option value="6989474">Badla</option>
				<option value="1277976">Badlapur</option>
				<option value="1277969">Badnera</option>
				<option value="1277905">Bag</option>
				<option value="1277936">Bagalkot</option>
				<option value="11184254">Bagbera</option>
				<option value="1277914">Bagda</option>
				<option value="10535317">Baghbardia</option>
				<option value="1432290">Bagila</option>
				<option value="1277882">Bagpat</option>
				<option value="10263103">Bagrola</option>
				<option value="10573526">Bagwara</option>
				<option value="1277835">Bahadurgarh</option>
				<option value="1441831">Bahadurpura</option>
				<option value="1277820">Baharampur</option>
				<option value="1277814">Baheri</option>
				<option value="1277799">Bahraich</option>
				<option value="10704798">Bahtarai</option>
				<option value="8740820">Baidrabad</option>
				<option value="1277780">Baidyabati</option>
				<option value="10722385">Baijalpur</option>
				<option value="1277771">Baijnath</option>
				<option value="1277769">Baikunthpur</option>
				<option value="7001775">Baipura</option>
				<option value="10152822">Bakali</option>
				<option value="1277690">Bakhli</option>
				<option value="10179533">Bakshiwala</option>
				<option value="1277661">Balaghat</option>
				<option value="1277647">Balanagar</option>
				<option value="1445310">Balapur</option>
				<option value="1277599">Balasore</option>
				<option value="10692586">Balda</option>
				<option value="1429903">Balhama</option>
				<option value="1277539">Bali</option>
				<option value="1277590">Bali</option>
				<option value="1277582">Balicha</option>
				<option value="10789787">Ballavolu</option>
				<option value="1277542">Ballur</option>
				<option value="1277538">Ballygunge</option>
				<option value="10727520">Balota</option>
				<option value="1277525">Balrampur</option>
				<option value="1277517">Balu</option>
				<option value="1441476">Balu</option>
				<option value="1277508">Balurghat</option>
				<option value="10812663">Balwari</option>
				<option value="1277477">Bambolim</option>
				<option value="1277461">Bamla</option>
				<option value="10919247">Bamroda</option>
				<option value="10733316">Bamta</option>
				<option value="10855039">Banahalli</option>
				<option value="6692796">Banaswadi</option>
				<option value="10891306">Bandadka</option>
				<option value="1277374">Bandgaon</option>
				<option value="1277362">Bandikui</option>
				<option value="1332494">Bandra</option>
				<option value="1277343">Baner</option>
				<option value="1277340">Banethi</option>
				<option value="1277324">Bangaon</option>
				<option value="1444387">Bani</option>
				<option value="1277297">Banihal</option>
				<option value="6994502">Bank</option>
				<option value="1277289">Banka</option>
				<option value="10261428">Bankner</option>
				<option value="1277264">Bankura</option>
				<option value="1277218">Bansur</option>
				<option value="1277214">Banswara</option>
				<option value="1277200">Banur</option>
				<option value="9892847">Banwasa</option>
				<option value="1277183">Bapatla</option>
				<option value="6417372">Barada</option>
				<option value="1278024">Baragaon</option>
				<option value="6992246">Barai</option>
				<option value="1277107">Barakar</option>
				<option value="1277100">Barakpur</option>
				<option value="1277091">Baramati</option>
				<option value="1277078">Barang</option>
				<option value="10732264">Bararta</option>
				<option value="6990087">Baraula</option>
				<option value="1277046">Barauni</option>
				<option value="1277044">Baraut</option>
				<option value="1277029">Barddhaman</option>
				<option value="1277022">Bardoli</option>
				<option value="1277013">Bareilly</option>
				<option value="1276995">Bargachia</option>
				<option value="1276988">Bargarh</option>
				<option value="1276954">Barhiya</option>
				<option value="1276948">Bari</option>
				<option value="10736150">Bari</option>
				<option value="10841744">Bariatu</option>
				<option value="1276942">Baripada</option>
				<option value="1276916">Barkuhi</option>
				<option value="10742653">Barmana</option>
				<option value="1276901">Barmer</option>
				<option value="1276895">Barnala</option>
				<option value="1276885">Baroda</option>
				<option value="6990628">Barodiya</option>
				<option value="1276870">Barpali</option>
				<option value="1276867">Barpeta</option>
				<option value="1348691">Baruipara</option>
				<option value="1276832">Baruipur</option>
				<option value="1440799">Barwa</option>
				<option value="1276810">Barwani</option>
				<option value="1275313">Barwas</option>
				<option value="6996133">Basantpura</option>
				<option value="10856052">Basavanagudi</option>
				<option value="1276765">Basi</option>
				<option value="1276759">Basirhat</option>
				<option value="1276736">Basti</option>
				<option value="10757557">Basupali</option>
				<option value="1445603">Baswapur</option>
				<option value="1276720">Batala</option>
				<option value="1431665">Batehra</option>
				<option value="6690741">Bathinda</option>
				<option value="1276666">Bawal</option>
				<option value="1276642">Bazpur</option>
				<option value="1276623">Bedradka</option>
				<option value="1276616">Begowal</option>
				<option value="1276609">Begusarai</option>
				<option value="1276607">Behala</option>
				<option value="6990495">Belal</option>
				<option value="1276556">Belapur</option>
				<option value="1276533">Belgaum</option>
				<option value="1276532">Belgharia</option>
				<option value="1276509">Bellary</option>
				<option value="1276504">Belmanna</option>
				<option value="1344086">Belpukur</option>
				<option value="10260660">Belra</option>
				<option value="10260962">Belra</option>
				<option value="10470610">Beltola</option>
				<option value="1277333">Bengaluru</option>
				<option value="1276452">Beraja</option>
				<option value="1276403">Betim</option>
				<option value="1276393">Bettiah</option>
				<option value="1276389">Betul</option>
				<option value="1276339">Bhadla</option>
				<option value="1276335">Bhadohi</option>
				<option value="1276325">Bhadrakh</option>
				<option value="1276320">Bhadreswar</option>
				<option value="1276300">Bhagalpur</option>
				<option value="1276291">Bhagor</option>
				<option value="10734085">Bhagrana</option>
				<option value="1276283">Bhagwa</option>
				<option value="6989451">Bhagwanpura</option>
				<option value="10146494">Bhalawag</option>
				<option value="10702761">Bhallowal</option>
				<option value="1276191">Bhandara</option>
				<option value="1276178">Bhander</option>
				<option value="1276174">Bhandup</option>
				<option value="1276128">Bharatpur</option>
				<option value="10713624">Bharoli</option>
				<option value="6995621">Bharthana</option>
				<option value="1276100">Bharuch</option>
				<option value="10265961">Bhaskola</option>
				<option value="1276074">Bhatha</option>
				<option value="1276067">Bhatkal</option>
				<option value="1276058">Bhatpara</option>
				<option value="1276037">Bhavani</option>
				<option value="1276032">Bhavnagar</option>
				<option value="1276028">Bhawan</option>
				<option value="1276023">Bhawanipatna</option>
				<option value="10694520">Bhendsar</option>
				<option value="1275971">Bhilai</option>
				<option value="1275960">Bhilwara</option>
				<option value="1275947">Bhimavaram</option>
				<option value="7279747">Bhiwadi</option>
				<option value="1275901">Bhiwandi</option>
				<option value="1275899">Bhiwani</option>
				<option value="10700917">Bhoman</option>
				<option value="1275841">Bhopal</option>
				<option value="1275817">Bhubaneswar</option>
				<option value="1275812">Bhuj</option>
				<option value="1275804">Bhum</option>
				<option value="1275778">Bhusaval</option>
				<option value="1275759">Bibinagar</option>
				<option value="10282656">Bidanasi</option>
				<option value="1275738">Bidar</option>
				<option value="1275701">Bijapur</option>
				<option value="1275708">Bijaynagar</option>
				<option value="10263084">Bijwasan</option>
				<option value="1275665">Bikaner</option>
				<option value="7018548">Bilai</option>
				<option value="1275631">Bilaspur</option>
				<option value="1275637">Bilaspur</option>
				<option value="1275622">Bilga</option>
				<option value="1275619">Bilgi</option>
				<option value="1275610">Bilimora</option>
				<option value="9036312">Birapurusottampur</option>
				<option value="1275526">Birbhaddar</option>
				<option value="1275463">Bishnupur</option>
				<option value="10265298">Bisrakh</option>
				<option value="1275388">Bodinayakkanur</option>
				<option value="10825290">Bohit</option>
				<option value="1275368">Boisar</option>
				<option value="1463375">Bokadvira</option>
				<option value="1275346">Bolpur</option>
				<option value="10895304">Bommanahalli</option>
				<option value="1275321">Bongaigaon</option>
				<option value="1275248">Borivali</option>
				<option value="1275230">Borsad</option>
				<option value="1275198">Brahmapur</option>
				<option value="1275178">Bualpui</option>
				<option value="10789445">Buddam</option>
				<option value="10849892">Bukkapuram</option>
				<option value="1275120">Bulandshahr</option>
				<option value="1275117">Buldana</option>
				<option value="1275103">Bundi</option>
				<option value="10261509">Burari</option>
				<option value="10698743">Burewal</option>
				<option value="1275050">Burla</option>
				<option value="1275046">Burnpur</option>
				<option value="8441268">Byahatti</option>
				<option value="1273858">Calangute</option>
				<option value="1274989">Candolim</option>
				<option value="1274977">Caranzalem</option>
				<option value="1274928">Chaibasa</option>
				<option value="1348982">Chakdaha</option>
				<option value="1443492">Chalahal</option>
				<option value="11061138">Chalthi</option>
				<option value="1274837">Champa</option>
				<option value="1274832">Champanagar</option>
				<option value="1348675">Champdani</option>
				<option value="1274814">Chamundi</option>
				<option value="1274693">Chanda</option>
				<option value="1274784">Chandannagar</option>
				<option value="1274746">Chandigarh</option>
				<option value="1348740">Chanditala</option>
				<option value="1274726">Chandod</option>
				<option value="1274720">Chandpara</option>
				<option value="1274714">Chandpur</option>
				<option value="1274767">Chanduasi</option>
				<option value="1274664">Changanacheri</option>
				<option value="1274662">Changatpuri</option>
				<option value="1274645">Chani</option>
				<option value="1274641">Channapatna</option>
				<option value="1349195">Chapra</option>
				<option value="1274572">Charkhi</option>
				<option value="1274569">Charmadi</option>
				<option value="1274511">Chaukhandi</option>
				<option value="1274468">Chavakkad</option>
				<option value="11186354">Chayalode</option>
				<option value="10924976">Chelakkad</option>
				<option value="10925351">Cheliya</option>
				<option value="10925345">Chemancheri</option>
				<option value="7279753">Chembur</option>
				<option value="8181689">Chendamangalam</option>
				<option value="1274430">Chengalpattu</option>
				<option value="1274428">Chengannur</option>
				<option value="1264527">Chennai</option>
				<option value="10930098">Chennara</option>
				<option value="1465780">Chepauk</option>
				<option value="1274406">Cherrapunjee</option>
				<option value="10792588">Cherthala</option>
				<option value="10877828">Cherur</option>
				<option value="10545615">Chetganj</option>
				<option value="11184820">Chevitikallu</option>
				<option value="1274304">Chhindwara</option>
				<option value="1274276">Chhuri</option>
				<option value="1255647">Chicacole</option>
				<option value="1274256">Chidambaram</option>
				<option value="1274250">Chikhaldara</option>
				<option value="1274235">Chikhli</option>
				<option value="1274220">ChikmagalÅ«r</option>
				<option value="1274218">Chikodi</option>
				<option value="10768877">Chilukuru</option>
				<option value="1274165">Chinchvad</option>
				<option value="1274129">Chintamani</option>
				<option value="1274119">Chiplun</option>
				<option value="10910176">Chirakkal</option>
				<option value="1274106">Chirala</option>
				<option value="10771781">Chirumamilla</option>
				<option value="1274056">Chitradurga</option>
				<option value="1274043">Chittaranjan</option>
				<option value="10877860">Chittari</option>
				<option value="1274040">Chittaurgarh</option>
				<option value="1274033">Chittoor</option>
				<option value="7001788">Chokla</option>
				<option value="1465774">Choolai</option>
				<option value="1273919">Chunchura</option>
				<option value="1273915">Chungtia</option>
				<option value="1273892">Churu</option>
				<option value="1273865">Coimbatore</option>
				<option value="1273862">Colaba</option>
				<option value="1273847">Colva</option>
				<option value="1344069">Contai</option>
				<option value="1273834">Coondapoor</option>
				<option value="1273833">Coonoor</option>
				<option value="1273815">Cossipore</option>
				<option value="1273810">Covelong</option>
				<option value="1273802">Cuddalore</option>
				<option value="1268246">Cumbum</option>
				<option value="1273793">Cuncolim</option>
				<option value="1273788">Curchorem</option>
				<option value="1273783">Curtorim</option>
				<option value="1273780">Cuttack</option>
				<option value="1273766">Dabhoi</option>
				<option value="1444889">Dabri</option>
				<option value="10261578">Dad</option>
				<option value="1273724">Dadri</option>
				<option value="1273708">Dahanu</option>
				<option value="1349167">Dakshin</option>
				<option value="11184897">Dakshineswar</option>
				<option value="1273636">Dalmianagar</option>
				<option value="1273618">Daman</option>
				<option value="1463380">Danda</option>
				<option value="1272346">Darang</option>
				<option value="1273491">Darbhanga</option>
				<option value="1273484">Dargah</option>
				<option value="8593714">Dargamitta</option>
				<option value="1273477">Daria</option>
				<option value="1273467">Darjeeling</option>
				<option value="1273448">Darsi</option>
				<option value="10899602">Dasanur</option>
				<option value="1273410">Dasuya</option>
				<option value="1445663">Daulapur</option>
				<option value="1273369">Dausa</option>
				<option value="1273368">Davangere</option>
				<option value="1348727">Debandi</option>
				<option value="1272513">Deesa</option>
				<option value="6954188">Dehradun</option>
				<option value="1273294">Delhi</option>
				<option value="1273265">Deoband</option>
				<option value="1273201">Deori</option>
				<option value="1273166">Dergaon</option>
				<option value="1273117">Devapur</option>
				<option value="1273118">Devapur</option>
				<option value="6988864">Devsar</option>
				<option value="1273066">Dewas</option>
				<option value="10259543">Dhaipai</option>
				<option value="10179745">Dhakas</option>
				<option value="1272997">Dhamtari</option>
				<option value="1272979">Dhanbad</option>
				<option value="10547982">Dhandhorpur</option>
				<option value="6991090">Dhanori</option>
				<option value="1272892">Dhar</option>
				<option value="1272832">Dharamsala</option>
				<option value="1272873">Dharapuram</option>
				<option value="1272866">Dharavi</option>
				<option value="1272849">Dharmapuram</option>
				<option value="1272847">Dharmapuri</option>
				<option value="1445672">Dharmaram</option>
				<option value="1272842">Dharmavaram</option>
				<option value="1272818">Dharwad</option>
				<option value="10025984">Dhaula</option>
				<option value="1272805">Dhaulpur</option>
				<option value="1272780">Dhenkanal</option>
				<option value="1272720">Dhoraji</option>
				<option value="1272699">Dhrol</option>
				<option value="1272691">Dhule</option>
				<option value="1272670">Dhuri</option>
				<option value="1272648">Dibrugarh</option>
				<option value="1272629">Digboi</option>
				<option value="1272615">Dighori</option>
				<option value="1272552">Dimapur</option>
				<option value="1273581">Dinapore</option>
				<option value="1272543">Dindigul</option>
				<option value="1272508">Dispur</option>
				<option value="1272502">Diu</option>
				<option value="1272476">Doda</option>
				<option value="1273687">Dohad</option>
				<option value="1272423">Dombivali</option>
				<option value="10770589">Donkada</option>
				<option value="1272237">Dumka</option>
				<option value="1272195">Dungri</option>
				<option value="1272181">Durg</option>
				<option value="1272175">Durgapur</option>
				<option value="1272140">Dwarka</option>
				<option value="1272110">Edapalli</option>
				<option value="11185179">Edavilangu</option>
				<option value="1272103">Egmore</option>
				<option value="1272101">Egra</option>
				<option value="1272051">Ellore</option>
				<option value="1272039">Ennur</option>
				<option value="1272027">Eral</option>
				<option value="1272022">Erattupetta</option>
				<option value="1272018">Ernakulam</option>
				<option value="1272013">Erode</option>
				<option value="10929650">Etakkad</option>
				<option value="1271987">Etawah</option>
				<option value="1271951">Faridabad</option>
				<option value="1271949">Faridkot</option>
				<option value="10800648">Fatepura</option>
				<option value="1442050">Fazalpura</option>
				<option value="1271891">Fazilka</option>
				<option value="1271888">Ferokh</option>
				<option value="1271883">Ferozepore</option>
				<option value="1271873">Fort</option>
				<option value="1271976">Fyzabad</option>
				<option value="1271850">Gadag</option>
				<option value="1271847">Gadarwara</option>
				<option value="1439831">Gadigarh</option>
				<option value="1436724">Gagsina</option>
				<option value="1271803">Gaighata</option>
				<option value="1271780">Gajraula</option>
				<option value="7302833">Gajuwaka</option>
				<option value="1271729">Gandarbal</option>
				<option value="1271717">Gandhidham</option>
				<option value="7004661">Gandhigram</option>
				<option value="1271715">Gandhinagar</option>
				<option value="1439930">Gandhinagar</option>
				<option value="7005236">Ganeshpura</option>
				<option value="10437040">Ganeshwadi</option>
				<option value="1271685">Ganganagar</option>
				<option value="1271670">Gangarampur</option>
				<option value="1271631">Gangtok</option>
				<option value="1271613">Gannavaram</option>
				<option value="1271575">Garhdiwala</option>
				<option value="1271530">Garifa</option>
				<option value="1348674">Garulia</option>
				<option value="1271439">Gaya</option>
				<option value="1271400">Ghaghra</option>
				<option value="1271375">Ghansoli</option>
				<option value="1271346">Ghatal</option>
				<option value="1271330">Ghatkopar</option>
				<option value="1271308">Ghaziabad</option>
				<option value="1271306">Ghazipur</option>
				<option value="1271213">Giddalur</option>
				<option value="1271175">Giridih</option>
				<option value="1271107">Godhra</option>
				<option value="1271079">Gohana</option>
				<option value="10449412">Gojegaon</option>
				<option value="1271067">Gokak</option>
				<option value="1271050">Golaghat</option>
				<option value="10770562">Gopalapatnam</option>
				<option value="1270927">Gorakhpur</option>
				<option value="1270914">Goregaon</option>
				<option value="1443570">Gori</option>
				<option value="1270873">Gothva</option>
				<option value="9072803">Gotri</option>
				<option value="7001518">Govindpura</option>
				<option value="1270800">Gudiyatham</option>
				<option value="1270797">Gudluru</option>
				<option value="1270776">Guindy</option>
				<option value="1348899">Gujrat</option>
				<option value="1270752">Gulbarga</option>
				<option value="10784197">Gumadam</option>
				<option value="1270711">Guna</option>
				<option value="1270710">Gunadala</option>
				<option value="1465922">Gunduperumbedu</option>
				<option value="10854059">Gunjur</option>
				<option value="1270674">Gunnaur</option>
				<option value="1270668">Guntur</option>
				<option value="1270667">Gunupur</option>
				<option value="1270647">Gurdaspur</option>
				<option value="1270642">Gurgaon</option>
				<option value="10840554">Guttikonda</option>
				<option value="1271476">Guwahati</option>
				<option value="1270583">Gwalior</option>
				<option value="1270568">Habra</option>
				<option value="1270558">Hadapsar</option>
				<option value="1349032">Hadia</option>
				<option value="1270543">Haflong</option>
				<option value="1270525">Hajipur</option>
				<option value="1270519">Hakimpet</option>
				<option value="1344377">Haldia</option>
				<option value="1270498">Haldwani</option>
				<option value="1270466">Halvad</option>
				<option value="1270454">Hamirpur</option>
				<option value="1270455">Hamirpur</option>
				<option value="1270444">Hanamkonda</option>
				<option value="1270417">Hansi</option>
				<option value="1270407">Hanumangarh</option>
				<option value="1270393">Hapur</option>
				<option value="1270351">Haridwar</option>
				<option value="1348581">Haripur</option>
				<option value="1270265">Harur</option>
				<option value="1436716">Haryana</option>
				<option value="1270251">Hasanpur</option>
				<option value="1270239">Hassan</option>
				<option value="1270210">Hatia</option>
				<option value="11185374">Hatiara</option>
				<option value="1270164">Hazaribagh</option>
				<option value="6988682">Hetamsar</option>
				<option value="11231768">hh11</option>
				<option value="1270099">Himatnagar</option>
				<option value="1270090">Hindaun</option>
				<option value="1270077">Hinganghat</option>
				<option value="1270032">Hiriyur</option>
				<option value="1270022">Hisar</option>
				<option value="10518695">Hiwara</option>
				<option value="1269976">Honavar</option>
				<option value="1269939">Hoshangabad</option>
				<option value="1269935">Hospet</option>
				<option value="1269934">Hosur</option>
				<option value="1270396">Howrah</option>
				<option value="1269920">Hubli</option>
				<option value="1269910">Hugli</option>
				<option value="1269843">Hyderabad</option>
				<option value="1269834">Ichalkaranji</option>
				<option value="1269831">Ichapur</option>
				<option value="1269818">Idar</option>
				<option value="1269811">Idukki</option>
				<option value="1269810">Igatpuri</option>
				<option value="1269771">Imphal</option>
				<option value="1269761">Indapur</option>
				<option value="1269754">Indas</option>
				<option value="11101802">Indirapuram</option>
				<option value="1269743">Indore</option>
				<option value="9212569">Injambakkam</option>
				<option value="1269693">Irinjalakuda</option>
				<option value="1269692">Iritty</option>
				<option value="10432482">Irla</option>
				<option value="1269668">Islampur</option>
				<option value="1269655">Itanagar</option>
				<option value="1269653">Itarsi</option>
				<option value="1269633">Jabalpur</option>
				<option value="1269627">Jadan</option>
				<option value="1269605">Jagadhri</option>
				<option value="1269585">Jagatdal</option>
				<option value="1269581">Jagatsinghapur</option>
				<option value="1269578">Jagdalpur</option>
				<option value="8739972">Jagiroad</option>
				<option value="1269564">Jagraon</option>
				<option value="1433149">Jagti</option>
				<option value="1269562">Jagtial</option>
				<option value="1269551">Jahangirabad</option>
				<option value="1269515">Jaipur</option>
				<option value="11013899">Jairampur</option>
				<option value="1269477">Jajpur</option>
				<option value="1269453">Jakrem</option>
				<option value="1269439">Jalalpur</option>
				<option value="1268782">Jalandhar</option>
				<option value="1269450">Jalhalli</option>
				<option value="1269395">Jalna</option>
				<option value="1269388">Jalpaiguri</option>
				<option value="1269321">Jammu</option>
				<option value="1269317">Jamnagar</option>
				<option value="1269300">Jamshedpur</option>
				<option value="1445744">Jangaon</option>
				<option value="1441588">Janipur</option>
				<option value="10469748">Jaripatka</option>
				<option value="1269135">Jaunpur</option>
				<option value="1269093">Jaynagar</option>
				<option value="1443495">Jeora</option>
				<option value="1269065">Jetpur</option>
				<option value="1269092">Jeypore</option>
				<option value="1269632">Jhabrera</option>
				<option value="1269042">Jhajjar</option>
				<option value="1269033">Jhalamand</option>
				<option value="1269027">Jhalawar</option>
				<option value="1269006">Jhansi</option>
				<option value="1268990">Jhargram</option>
				<option value="1268977">Jharsuguda</option>
				<option value="1268936">Jhunjhunun</option>
				<option value="1268907">Jind</option>
				<option value="1268865">Jodhpur</option>
				<option value="1268854">Jogeshwari</option>
				<option value="1268849">Jogindarnagar</option>
				<option value="1268820">Jorhat</option>
				<option value="1268810">Jowai</option>
				<option value="1268799">Jugsalai</option>
				<option value="1268795">Juhu</option>
				<option value="1268773">Junagadh</option>
				<option value="1268768">Jundla</option>
				<option value="1273800">Kadapa</option>
				<option value="1268707">Kadayanallur</option>
				<option value="1268682">Kadegaon</option>
				<option value="1268680">Kadi</option>
				<option value="9072777">Kadodara</option>
				<option value="11185507">Kainoor</option>
				<option value="1443376">Kair</option>
				<option value="1268593">Kaithal</option>
				<option value="1268566">Kakdwip</option>
				<option value="1268561">Kakinada</option>
				<option value="11073561">Kakkanad</option>
				<option value="10878022">Kakkat</option>
				<option value="10263070">Kakrola</option>
				<option value="1268513">Kaladhungi</option>
				<option value="1268512">Kaladi</option>
				<option value="1268482">Kalamboli</option>
				<option value="7746381">Kalan</option>
				<option value="1349089">Kalikapur</option>
				<option value="10888135">Kallahalli</option>
				<option value="1268338">Kalol</option>
				<option value="1268328">Kalpakkam</option>
				<option value="1268327">Kalpetta</option>
				<option value="1268304">Kalva</option>
				<option value="1268299">Kalwara</option>
				<option value="1268295">Kalyan</option>
				<option value="1268293">Kalyani</option>
				<option value="1268205">Kamthi</option>
				<option value="1268159">Kanchipuram</option>
				<option value="1268715">Kanchrapara</option>
				<option value="1268135">Kandi</option>
				<option value="1268084">Kangar</option>
				<option value="1268015">Kanhangad</option>
				<option value="11184277">Kanjari</option>
				<option value="1268025">Kankinara</option>
				<option value="1268022">Kankon</option>
				<option value="1430027">Kankot</option>
				<option value="10910201">Kannadiparamba</option>
				<option value="1268011">Kannauj</option>
				<option value="1268008">Kanniyakumari</option>
				<option value="1274987">Kannur</option>
				<option value="1267995">Kanpur</option>
				<option value="10778891">Kanteru</option>
				<option value="1267970">Kantharia</option>
				<option value="10877560">Kanyana</option>
				<option value="10448100">Kapasda</option>
				<option value="1267904">Karad</option>
				<option value="1267887">Karaikal</option>
				<option value="1267885">Karaikudi</option>
				<option value="1431881">Karan</option>
				<option value="10929655">Karaparamba</option>
				<option value="1443496">Karer</option>
				<option value="1267755">Karimnagar</option>
				<option value="1267754">Karimpur</option>
				<option value="1267742">Karjat</option>
				<option value="1267739">Karkala</option>
				<option value="1267716">Karmala</option>
				<option value="1267708">Karnal</option>
				<option value="1267669">Kartarpur</option>
				<option value="1267648">Karur</option>
				<option value="1267635">Karwar</option>
				<option value="1267616">Kasaragod</option>
				<option value="1267605">Kasauli</option>
				<option value="1267579">Kashipur</option>
				<option value="1267509">Kathar</option>
				<option value="1267495">Kathlal</option>
				<option value="1267486">Kathua</option>
				<option value="1267457">Katoya</option>
				<option value="1267435">Kattanam</option>
				<option value="10846001">Kattingere</option>
				<option value="6694343">Kaudiar</option>
				<option value="1267394">Kavali</option>
				<option value="1465873">Kavanur</option>
				<option value="1267390">Kavaratti</option>
				<option value="1267369">Kawardha</option>
				<option value="1267361">Kayalpattinam</option>
				<option value="1267360">Kayamkulam</option>
				<option value="1267355">Kazhakuttam</option>
				<option value="1267331">Kelamangalam</option>
				<option value="1267330">Kelambakkam</option>
				<option value="10898953">Kenchanahalli</option>
				<option value="1267283">Kendraparha</option>
				<option value="1267195">Khadki</option>
				<option value="1267189">Khagaria</option>
				<option value="1267187">Khagaul</option>
				<option value="1267090">Khambhat</option>
				<option value="10508566">Khamda</option>
				<option value="1267084">Khamgaon</option>
				<option value="1267076">Khammam</option>
				<option value="1267070">Khana</option>
				<option value="1267066">Khanapara</option>
				<option value="1267034">Khandsa</option>
				<option value="1267031">Khandwa</option>
				<option value="1267016">Khanna</option>
				<option value="1266976">Kharagpur</option>
				<option value="1266960">Kharar</option>
				<option value="1266945">Khardaha</option>
				<option value="7005034">Kharduti</option>
				<option value="8133395">Kharghar</option>
				<option value="1266928">Khargone</option>
				<option value="1266872">Kharsia</option>
				<option value="1266849">Khatauli</option>
				<option value="1266814">Khed</option>
				<option value="1266809">Kheda</option>
				<option value="1266774">Kheralu</option>
				<option value="1266744">Khetri</option>
				<option value="1348684">Khilkapur</option>
				<option value="1266666">Khopoli</option>
				<option value="1266622">Khunti</option>
				<option value="1266616">Khurda</option>
				<option value="1465617">Kilpauk</option>
				<option value="1266508">Kiratpur</option>
				<option value="1266489">Kishanganj</option>
				<option value="1273874">Kochi</option>
				<option value="1266425">Kodaikanal</option>
				<option value="1266385">Kodungallur</option>
				<option value="1462744">Kohar</option>
				<option value="1266366">Kohima</option>
				<option value="1266330">Kokrajhar</option>
				<option value="1266321">Kolad</option>
				<option value="1465885">Kolapakkam</option>
				<option value="1266305">Kolar</option>
				<option value="1266285">Kolhapur</option>
				<option value="1275004">Kolkata</option>
				<option value="1259091">Kollam</option>
				<option value="1445464">Kondapur</option>
				<option value="1266183">Koni</option>
				<option value="1266179">Konnagar</option>
				<option value="1465577">Konnur</option>
				<option value="1463397">Kopar</option>
				<option value="6695463">Koramangala</option>
				<option value="1466097">Korattur</option>
				<option value="1266122">Korba</option>
				<option value="1266049">Kota</option>
				<option value="1266038">Kotagiri</option>
				<option value="1266014">Kotdwara</option>
				<option value="1445324">Kothaguda</option>
				<option value="7279734">Kotkapura</option>
				<option value="1265938">Kottagudem</option>
				<option value="1265932">Kottakkal</option>
				<option value="1265916">Kottarakara</option>
				<option value="1265911">Kottayam</option>
				<option value="1465644">Kotturpuram</option>
				<option value="1265891">Kovilpatti</option>
				<option value="1265886">Kovvur</option>
				<option value="1465631">Koyambedu</option>
				<option value="1265877">Koyyalagudem</option>
				<option value="1265873">Kozhikode</option>
				<option value="1265863">Krishnagiri</option>
				<option value="1265859">Krishnanagar</option>
				<option value="1348742">Krishnapur</option>
				<option value="10790209">Krishnapuram</option>
				<option value="1265767">Kukatpalli</option>
				<option value="10256341">Kular</option>
				<option value="1265742">Kulasegaram</option>
				<option value="10265307">Kulesra</option>
				<option value="8223943">Kumarapalayam</option>
				<option value="1265687">Kumarkera</option>
				<option value="1265683">Kumbakonam</option>
				<option value="10627510">Kumbalam</option>
				<option value="10733928">Kumbh</option>
				<option value="1265645">Kumta</option>
				<option value="1265640">Kunchanapalle</option>
				<option value="1432442">Kundan</option>
				<option value="10730588">Kundargi</option>
				<option value="1265579">Kunnamkulam</option>
				<option value="1265496">Kurla</option>
				<option value="1265491">Kurnool</option>
				<option value="8986322">Kurukshetra</option>
				<option value="1265451">Kushalnagar</option>
				<option value="1265436">Kusugal</option>
				<option value="1265418">Kutiatodu</option>
				<option value="1265395">Kuttippuram</option>
				<option value="1265387">Kuzhithurai</option>
				<option value="1265331">Ladnun</option>
				<option value="1265323">Ladwa</option>
				<option value="8740373">Laitumkhrah</option>
				<option value="1265242">Lakhimpur</option>
				<option value="1265187">Lalaguda</option>
				<option value="1265014">Latur</option>
				<option value="1264917">Liluah</option>
				<option value="1445527">Lingampalli</option>
				<option value="6692782">LingarajaPuram</option>
				<option value="1264850">Lohaghat</option>
				<option value="1264816">Lohogaon</option>
				<option value="1264793">Lonavla</option>
				<option value="1264773">Loni</option>
				<option value="1264779">Loni</option>
				<option value="1264735">Luckeesarai</option>
				<option value="1264733">Lucknow</option>
				<option value="1264728">Ludhiana</option>
				<option value="10013568">Luhri</option>
				<option value="1264688">Lunglei</option>
				<option value="1264644">Machhiwara</option>
				<option value="1264637">Machilipatnam</option>
				<option value="1264621">Madanapalle</option>
				<option value="6990138">Madanpur</option>
				<option value="1264588">Madgaon</option>
				<option value="1264586">Madh</option>
				<option value="1465594">Madhavaram</option>
				<option value="1264569">Madhoganj</option>
				<option value="1264557">Madhuban</option>
				<option value="1264551">Madhupur</option>
				<option value="1264543">Madhyamgram</option>
				<option value="1465825">Madipakkam</option>
				<option value="1264521">Madurai</option>
				<option value="1264491">Mahabaleshwar</option>
				<option value="1263997">Mahabalipuram</option>
				<option value="1264489">Mahad</option>
				<option value="1264414">Mahasamund</option>
				<option value="1264403">Mahe</option>
				<option value="1264389">Mahesana</option>
				<option value="1264381">Mahim</option>
				<option value="7304193">Mahipalpur</option>
				<option value="1264352">Mahrauli</option>
				<option value="1264292">Mainpuri</option>
				<option value="1263684">Majalgaon</option>
				<option value="10729216">Majari</option>
				<option value="1264215">Makhu</option>
				<option value="1264206">Makrana</option>
				<option value="1264179">Malad</option>
				<option value="1264154">Malappuram</option>
				<option value="1264121">Maldah</option>
				<option value="1264115">Malegaon</option>
				<option value="11185813">Malikipuram</option>
				<option value="1264074">Malkapur</option>
				<option value="10907043">Malkapuram</option>
				<option value="6692915">Malleshwaram</option>
				<option value="1264010">Malur</option>
				<option value="1263968">Manali</option>
				<option value="1263959">Mananthavady</option>
				<option value="1263937">Manchar</option>
				<option value="1263936">Mancherial</option>
				<option value="1263918">Mandal</option>
				<option value="1263905">Mandangarh</option>
				<option value="1263868">Mandhar</option>
				<option value="1263862">Mandi</option>
				<option value="1263852">Mandla</option>
				<option value="1263850">Mandleshwar</option>
				<option value="1263834">Mandsaur</option>
				<option value="1263828">Mandve</option>
				<option value="1263814">Mandya</option>
				<option value="1263797">Mangalagiri</option>
				<option value="1263795">Mangalam</option>
				<option value="1263780">Mangalore</option>
				<option value="1263773">Mangaon</option>
				<option value="1263752">Mangrol</option>
				<option value="1263707">Manipala</option>
				<option value="1349375">Manipur</option>
				<option value="1263694">Manjeri</option>
				<option value="1263659">Mannargudi</option>
				<option value="1263622">Mansa</option>
				<option value="8335136">Mansarovar</option>
				<option value="1263580">Mapuca</option>
				<option value="11185833">Maradu</option>
				<option value="10933957">Marancheri</option>
				<option value="1263494">Marmagao</option>
				<option value="10783008">Marripalem</option>
				<option value="11185837">Marthandam</option>
				<option value="10213187">Marud</option>
				<option value="6692792">Mathikere</option>
				<option value="1263364">Mathura</option>
				<option value="1263322">Matunga</option>
				<option value="1263285">Mavelikara</option>
				<option value="1263269">Mawiong</option>
				<option value="1263241">Mazgaon</option>
				<option value="1263230">Medak</option>
				<option value="1263220">Medinipur</option>
				<option value="1263214">Meerut</option>
				<option value="1263168">Melaghar</option>
				<option value="1263151">Melur</option>
				<option value="1263104">Mettuppalaiyam</option>
				<option value="1263101">Mettur</option>
				<option value="1263080">Mhow</option>
				<option value="1263057">Mihona</option>
				<option value="1440736">Mill</option>
				<option value="1263027">Miraj</option>
				<option value="1263015">Mirganj</option>
				<option value="1262995">Mirzapur</option>
				<option value="1262982">Mithapur</option>
				<option value="10446813">Miyapur</option>
				<option value="1262958">Modasa</option>
				<option value="8440756">Modinagar</option>
				<option value="1262951">Moga</option>
				<option value="1262933">Mohala</option>
				<option value="6992326">Mohali</option>
				<option value="1262928">Mohan</option>
				<option value="1262801">Moradabad</option>
				<option value="1262771">Morena</option>
				<option value="1262426">Morinda</option>
				<option value="1262775">Morvi</option>
				<option value="1262725">Mota</option>
				<option value="1262710">Mothihari</option>
				<option value="1262596">Mukerian</option>
				<option value="1262578">Muktsar</option>
				<option value="1262566">Muluppilagadu</option>
				<option value="1275339">Mumbai</option>
				<option value="1262516">Mundargi</option>
				<option value="1262505">Mundhva</option>
				<option value="10263053">Mundka</option>
				<option value="1262497">Mundra</option>
				<option value="1262491">Mundwa</option>
				<option value="1262482">Munger</option>
				<option value="1262412">Murshidabad</option>
				<option value="10609620">Musri</option>
				<option value="1262374">Mussoorie</option>
				<option value="7279735">Muvattupuzha</option>
				<option value="1262332">Muzaffarnagar</option>
				<option value="1262330">Muzaffarpur</option>
				<option value="1262321">Mysore</option>
				<option value="1261669">Nabadwip</option>
				<option value="1262319">Nabha</option>
				<option value="7002494">Nabipur</option>
				<option value="1445888">Nacharam</option>
				<option value="1262292">Nadiad</option>
				<option value="1262260">Nagapattinam</option>
				<option value="1262253">Nagar</option>
				<option value="1262257">Nagar</option>
				<option value="1432314">Nagar</option>
				<option value="1445276">Nagaram</option>
				<option value="6692838">Nagarbhavi</option>
				<option value="1262216">Nagaur</option>
				<option value="1262209">Nagda</option>
				<option value="1262204">Nagercoil</option>
				<option value="1262200">Nagina</option>
				<option value="1262185">Nagore</option>
				<option value="1262180">Nagpur</option>
				<option value="1262151">Nahan</option>
				<option value="7302855">Naharlagun</option>
				<option value="1262131">Naihati</option>
				<option value="1262117">Nainital</option>
				<option value="1262111">Najafgarh</option>
				<option value="11071413">Nakhatrana</option>
				<option value="1262097">Nakodar</option>
				<option value="1262083">Nalagarh</option>
				<option value="1262067">Nalgonda</option>
				<option value="1262039">Namakkal</option>
				<option value="1465879">Nandambakkam</option>
				<option value="1465838">Nandanam</option>
				<option value="1261977">Nanded</option>
				<option value="1261960">Nandigama</option>
				<option value="1261927">Nandyal</option>
				<option value="1261914">Nangli</option>
				<option value="1261910">Nanjangud</option>
				<option value="1261872">Naraina</option>
				<option value="1261848">Narasaraopet</option>
				<option value="1261828">Narayangarh</option>
				<option value="1349099">Narayanpur</option>
				<option value="1261772">Narnaul</option>
				<option value="1261768">Naroda</option>
				<option value="1445901">Narsapur</option>
				<option value="1261754">Narsimhapur</option>
				<option value="1261731">Nashik</option>
				<option value="1261711">Nathdwara</option>
				<option value="1444952">Nathupur</option>
				<option value="1261680">Naupada</option>
				<option value="1261661">Navelim</option>
				<option value="1261653">Navsari</option>
				<option value="7002395">Nawada</option>
				<option value="1261631">Nawada</option>
				<option value="1261598">Nawashahr</option>
				<option value="1261564">Nazareth</option>
				<option value="1261539">Nelamangala</option>
				<option value="1261529">Nellore</option>
				<option value="1261512">Neral</option>
				<option value="1261485">Newada</option>
				<option value="1261473">Neyveli</option>
				<option value="1261409">Nikora</option>
				<option value="1261394">Nileshwar</option>
				<option value="1261309">Nipani</option>
				<option value="10930105">Niramaruthur</option>
				<option value="1261288">Nirmal</option>
				<option value="1261258">Nizamabad</option>
				<option value="1445173">Nizampet</option>
				<option value="7279746">Noida</option>
				<option value="1261227">Nokha</option>
				<option value="1261205">Nongstoin</option>
				<option value="1261145">Nuh</option>
				<option value="1261111">Nuvem</option>
				<option value="1261110">Nuzvid</option>
				<option value="1261045">Ongole</option>
				<option value="1253993">Ooty</option>
				<option value="1261039">Orai</option>
				<option value="1261012">Osmanabad</option>
				<option value="1261008">Ottappalam</option>
				<option value="1260959">Pachora</option>
				<option value="1260918">Padmanabhapuram</option>
				<option value="1260728">Palakkad</option>
				<option value="1260788">Palam</option>
				<option value="1260784">Palampur</option>
				<option value="1260671">Palani</option>
				<option value="1260777">Palanpur</option>
				<option value="1260771">Palasa</option>
				<option value="10789937">Palavakkam</option>
				<option value="1260743">Palayankottai</option>
				<option value="1260730">Palghar</option>
				<option value="1260716">Pali</option>
				<option value="1260719">Pali</option>
				<option value="1260694">Pallappatti</option>
				<option value="1260692">Pallavaram</option>
				<option value="10910174">Pallikunnu</option>
				<option value="1260667">Paloncha</option>
				<option value="1260637">Palwal</option>
				<option value="1260633">Pamarru</option>
				<option value="9972720">Pammal</option>
				<option value="1260577">Panchgani</option>
				<option value="1260546">Pandharpur</option>
				<option value="1260528">Pandu</option>
				<option value="1260482">Panihati</option>
				<option value="1260476">Panipat</option>
				<option value="1260607">Panjim</option>
				<option value="1260448">Panruti</option>
				<option value="1260445">Panskura</option>
				<option value="1260440">Pantnagar</option>
				<option value="1260434">Panvel</option>
				<option value="1260417">Papanasam</option>
				<option value="8441961">Pappampatti</option>
				<option value="1260401">Para</option>
				<option value="1260393">Paradip</option>
				<option value="1260375">Parappanangadi</option>
				<option value="1260341">Parbhani</option>
				<option value="10432129">Paregaon</option>
				<option value="1260333">Parel</option>
				<option value="1260328">Pargaon</option>
				<option value="1260225">Parur</option>
				<option value="1260221">Parvatsar</option>
				<option value="7279750">Parwanoo</option>
				<option value="1260173">Patan</option>
				<option value="1260138">Pathanamthitta</option>
				<option value="1260137">Pathankot</option>
				<option value="1260107">Patiala</option>
				<option value="1260086">Patna</option>
				<option value="1260052">Pattambi</option>
				<option value="1260045">Patti</option>
				<option value="1260046">Patti</option>
				<option value="1260040">Pattukkottai</option>
				<option value="6988735">Patusari</option>
				<option value="1260016">Pauri</option>
				<option value="1259994">Payyanur</option>
				<option value="1259954">Peddapuram</option>
				<option value="1259939">Pehowa</option>
				<option value="10877203">Pelur</option>
				<option value="1259931">Pen</option>
				<option value="1259907">Penugonda</option>
				<option value="1259896">Perambalur</option>
				<option value="1259895">Perambur</option>
				<option value="1259869">Pernem</option>
				<option value="1465869">Perumbakkam</option>
				<option value="7279739">Perumbavoor</option>
				<option value="1259855">Perundurai</option>
				<option value="11184574">Peruvemba</option>
				<option value="1259827">Phagwara</option>
				<option value="1259722">Phursungi</option>
				<option value="1259693">Pilani</option>
				<option value="1259686">Pilibhit</option>
				<option value="1259680">Pilkhuwa</option>
				<option value="1259605">Pipariya</option>
				<option value="1259508">Pithapuram</option>
				<option value="1259440">Pollachi</option>
				<option value="1259429">Ponda</option>
				<option value="10376565">Ponkunnam</option>
				<option value="1259411">Ponnani</option>
				<option value="1259409">Ponneri</option>
				<option value="1465707">Ponniammanmedu</option>
				<option value="1259400">Poonamalle</option>
				<option value="10778956">Poranki</option>
				<option value="1259397">Porayar</option>
				<option value="1259395">Porbandar</option>
				<option value="1259356">Powai</option>
				<option value="1259312">Proddatur</option>
				<option value="1259425">Puducherry</option>
				<option value="1259297">Pudukkottai</option>
				<option value="1259251">Pulwama</option>
				<option value="1259243">Punalur</option>
				<option value="1259229">Pune</option>
				<option value="1259217">Punnapra</option>
				<option value="7005230">Pura</option>
				<option value="1259184">Puri</option>
				<option value="1259166">Purnia</option>
				<option value="1259163">Puruliya</option>
				<option value="1259123">Puttur</option>
				<option value="1259124">Puttur</option>
				<option value="1259090">Qutba</option>
				<option value="1259064">Raebareli</option>
				<option value="1259021">Rahu</option>
				<option value="1259012">Raichur</option>
				<option value="1259009">Raiganj</option>
				<option value="1259005">Raigarh</option>
				<option value="1258993">Raikot</option>
				<option value="1258972">Raipur</option>
				<option value="1258978">Raipur</option>
				<option value="1258980">Raipur</option>
				<option value="1258952">Raisen</option>
				<option value="1258932">Rajahmundry</option>
				<option value="1258922">Rajampet</option>
				<option value="1258916">Rajapalaiyam</option>
				<option value="1258911">Rajapur</option>
				<option value="11056074">Rajawadi</option>
				<option value="1258869">Rajgarh</option>
				<option value="1258864">Rajgir</option>
				<option value="1258847">Rajkot</option>
				<option value="1258820">Rajpipla</option>
				<option value="1258803">Rajpura</option>
				<option value="1258756">Ramachandrapuram</option>
				<option value="1258744">Ramanagaram</option>
				<option value="1258740">Ramanathapuram</option>
				<option value="1258637">Ramnagar</option>
				<option value="1258599">Rampur</option>
				<option value="1258546">Ranaghat</option>
				<option value="1258526">Ranchi</option>
				<option value="1258478">Rani</option>
				<option value="1258470">Raniganj</option>
				<option value="1258380">Rasra</option>
				<option value="1258342">Ratlam</option>
				<option value="1258338">Ratnagiri</option>
				<option value="1258315">Raurkela</option>
				<option value="1258307">Raver</option>
				<option value="1258289">Rayagada</option>
				<option value="1258213">Renigunta</option>
				<option value="1258207">Renukoot</option>
				<option value="1258182">Rewa</option>
				<option value="1258178">Rewari</option>
				<option value="1258128">Rishikesh</option>
				<option value="1258126">Rishra</option>
				<option value="1258087">Rohini</option>
				<option value="1258076">Rohtak</option>
				<option value="1258044">Roorkee</option>
				<option value="1257951">Ropar</option>
				<option value="1348736">Rudrapur</option>
				<option value="1257994">Rukadi</option>
				<option value="6692770">SadashivaNagar</option>
				<option value="1257851">Sagar</option>
				<option value="1348788">Sahapur</option>
				<option value="1257806">Saharanpur</option>
				<option value="1257795">Sahibabad</option>
				<option value="1257782">Saidabad</option>
				<option value="1257771">Saiha</option>
				<option value="1257691">Sakoli</option>
				<option value="10809593">Sakroda</option>
				<option value="1257629">Salem</option>
				<option value="1465633">Saligramam</option>
				<option value="1257565">Samalkot</option>
				<option value="1257559">Samana</option>
				<option value="1257551">Samastipur</option>
				<option value="1257545">Samba</option>
				<option value="1257542">Sambalpur</option>
				<option value="1257508">Sampla</option>
				<option value="1257486">Sanand</option>
				<option value="10734830">Sanawar</option>
				<option value="1257456">Sandur</option>
				<option value="1257436">Sangamner</option>
				<option value="1257416">Sangli</option>
				<option value="1257402">Sangrur</option>
				<option value="6993063">Sanjarpur</option>
				<option value="1257369">Sankeshwar</option>
				<option value="1257347">Sanquelim</option>
				<option value="1257327">Santipur</option>
				<option value="1257325">Santoshpur</option>
				<option value="1257313">Sanwer</option>
				<option value="1257275">Sarai</option>
				<option value="1257198">Sardarshahr</option>
				<option value="1257093">Sarwar</option>
				<option value="1257055">Satara</option>
				<option value="1257022">Satna</option>
				<option value="1256995">Sattur</option>
				<option value="1257845">Saugor</option>
				<option value="1256959">Savda</option>
				<option value="1256922">Secunderabad</option>
				<option value="1466045">Sembedu</option>
				<option value="1256854">Sendhwa</option>
				<option value="1256832">Seohara</option>
				<option value="1256422">Serampore</option>
				<option value="1256769">Sewri</option>
				<option value="1445197">Shadnagar</option>
				<option value="1256752">Shahabad</option>
				<option value="1256741">Shahdara</option>
				<option value="1256739">Shahdol</option>
				<option value="1256722">Shahpur</option>
				<option value="1441451">Shakarpur</option>
				<option value="1256687">Shakurpur</option>
				<option value="1256671">Shamli</option>
				<option value="1256569">Sherkot</option>
				<option value="1256523">Shillong</option>
				<option value="1256237">Shimla</option>
				<option value="1256515">Shimoga</option>
				<option value="1256475">Shirpur</option>
				<option value="6693809">Sholinganallur</option>
				<option value="1256432">Shoranur</option>
				<option value="1256409">Shyamnagar</option>
				<option value="1256388">Sibsagar</option>
				<option value="1256320">Sikar</option>
				<option value="1256287">Silchar</option>
				<option value="1256525">Siliguri</option>
				<option value="1256259">Silvassa</option>
				<option value="1256244">Simhachalam</option>
				<option value="8199699">Singampunari</option>
				<option value="1256184">Singanallur</option>
				<option value="1256124">Singur</option>
				<option value="1256119">Sinnar</option>
				<option value="7001554">Sinwar</option>
				<option value="1256087">Sirhind</option>
				<option value="1256067">Sirohi</option>
				<option value="1256052">Sirsa</option>
				<option value="6988491">Sirsali</option>
				<option value="1256047">Sirsi</option>
				<option value="1256029">Siruguppa</option>
				<option value="1465856">Siruseri</option>
				<option value="1255983">Sitamarhi</option>
				<option value="1255969">Sitapur</option>
				<option value="1441936">Sitapura</option>
				<option value="1255963">Sitarganj</option>
				<option value="1255955">Siuri</option>
				<option value="1255953">Sivaganga</option>
				<option value="1255947">Sivakasi</option>
				<option value="1255927">Siwan</option>
				<option value="1255878">Sohana</option>
				<option value="1255850">Solan</option>
				<option value="1256436">Solapur</option>
				<option value="1255844">Solim</option>
				<option value="1255792">Sonamukhi</option>
				<option value="1255762">Songadh</option>
				<option value="1255744">Sonipat</option>
				<option value="1255716">Sopara</option>
				<option value="1255707">Soreng</option>
				<option value="1255634">Srinagar</option>
				<option value="1255633">Sringeri</option>
				<option value="1255630">Sriperumbudur</option>
				<option value="1255616">Srivilliputhur</option>
				<option value="1255491">Sultanpur</option>
				<option value="1255449">Sunam</option>
				<option value="1255437">Sundargarh</option>
				<option value="1255405">Suntikoppa</option>
				<option value="1255396">Supaul</option>
				<option value="1255361">Suratgarh</option>
				<option value="1255349">Surendranagar</option>
				<option value="1255344">Suriapet</option>
				<option value="1255326">Surpura</option>
				<option value="1255264">Tadepallegudem</option>
				<option value="11031073">Tajnipur</option>
				<option value="1255183">Tala</option>
				<option value="1255143">Talcher</option>
				<option value="1255062">Tambaram</option>
				<option value="1255046">Tamluk</option>
				<option value="1255018">Tanda</option>
				<option value="1254996">Tangasseri</option>
				<option value="1254972">Tankara</option>
				<option value="1254953">Tanuku</option>
				<option value="1254908">Taranagar</option>
				<option value="1254880">Tarikere</option>
				<option value="10930077">Tavanur</option>
				<option value="1254835">Tavarikere</option>
				<option value="1254808">Tehri</option>
				<option value="1254780">Tellicherry</option>
				<option value="1465648">Teynampet</option>
				<option value="1254710">Tezpur</option>
				<option value="11184387">Thaltej</option>
				<option value="1254661">Thane</option>
				<option value="1254649">Thanjavur</option>
				<option value="1442340">Thathwari</option>
				<option value="1254757">Thenali</option>
				<option value="10209720">Theni</option>
				<option value="1254744">Thenkasi</option>
				<option value="1254163">Thiruvananthapuram</option>
				<option value="1254589">Thiruvarur</option>
				<option value="9072827">Thodupuzha</option>
				<option value="8629640">Thoothukudi</option>
				<option value="1254187">Thrissur</option>
				<option value="1254444">Tindivanam</option>
				<option value="1254432">Tinsukia</option>
				<option value="1254390">Tiruchchendur</option>
				<option value="1254385">Tiruchengode</option>
				<option value="1254388">Tiruchi</option>
				<option value="1254361">Tirunelveli</option>
				<option value="1254348">Tiruppur</option>
				<option value="1254346">Tirur</option>
				<option value="1254345">Tirurangadi</option>
				<option value="1254335">Tiruvalla</option>
				<option value="1254331">Tiruvallur</option>
				<option value="1254327">Tiruvannamalai</option>
				<option value="1254319">Tiruvur</option>
				<option value="1254274">Tohana</option>
				<option value="1465601">Tondiarpet</option>
				<option value="1254241">Tonk</option>
				<option value="8443020">Trikkandiyur</option>
				<option value="1254162">Trombay</option>
				<option value="1254136">Tudiyalur</option>
				<option value="1254089">TumkÅ«r</option>
				<option value="1254054">Tuni</option>
				<option value="1254046">Tura</option>
				<option value="1254043">Turaiyur</option>
				<option value="1254040">Turavur</option>
				<option value="1253985">Udaipur</option>
				<option value="1253987">Udaipur</option>
				<option value="1253958">Udgir</option>
				<option value="1253956">Udhampur</option>
				<option value="1253944">Udumalaippettai</option>
				<option value="1253952">Udupi</option>
				<option value="1253914">Ujjain</option>
				<option value="1253894">Ulhasnagar</option>
				<option value="1253785">Un</option>
				<option value="1253782">Una</option>
				<option value="1253750">Unjha</option>
				<option value="1253747">Unnao</option>
				<option value="1253627">Uttarpara</option>
				<option value="1253593">Vadangali</option>
				<option value="1465632">Vadapalani</option>
				<option value="1253573">Vadodara</option>
				<option value="1252926">Vadodra</option>
				<option value="1253544">Vaikam</option>
				<option value="1466104">Valapuram</option>
				<option value="1253468">Valsad</option>
				<option value="1253452">Vandavasi</option>
				<option value="1253450">Vandiperiyar</option>
				<option value="1253437">Vaniyambadi</option>
				<option value="7279741">Vapi</option>
				<option value="1253405">Varanasi</option>
				<option value="1253401">Varca</option>
				<option value="1253392">Varkala</option>
				<option value="1253372">Vasai</option>
				<option value="1253367">Vasco</option>
				<option value="1253366">Vashi</option>
				<option value="8477246">Vavdi</option>
				<option value="1253286">Vellore</option>
				<option value="1253248">Venkatapuram</option>
				<option value="1253240">Vepery</option>
				<option value="1253237">Veraval</option>
				<option value="1253200">Vidisha</option>
				<option value="1253193">Vijapur</option>
				<option value="1253184">Vijayawada</option>
				<option value="1253181">Vikhroli</option>
				<option value="1253169">Villianur</option>
				<option value="1253166">Villupuram</option>
				<option value="1253150">Vinukonda</option>
				<option value="1253145">Viralimalai</option>
				<option value="1253133">Virar</option>
				<option value="1253102">Visakhapatnam</option>
				<option value="1253095">Visnagar</option>
				<option value="1253084">Vizianagaram</option>
				<option value="1253080">Vriddhachalam</option>
				<option value="1253077">Vuyyuru</option>
				<option value="1253074">Vyara</option>
				<option value="7870662">Vyttila</option>
				<option value="1253065">Wadala</option>
				<option value="1253056">Wadgaon</option>
				<option value="1253013">Wai</option>
				<option value="1252997">Walajapet</option>
				<option value="1252958">Wankaner</option>
				<option value="1252948">Warangal</option>
				<option value="1252942">Wardha</option>
				<option value="1465603">Washermanpet</option>
				<option value="1252859">Whitefield</option>
				<option value="1252834">Worli</option>
				<option value="1252797">Yamunanagar</option>
				<option value="1252795">Yanam</option>
				<option value="1252770">Yavatmal</option>
				<option value="6695474">Yelachenahalli</option>
				<option value="1252758">Yelahanka</option>
				<option value="1252738">Yeola</option>
				<option value="1252734">Yercaud</option>
			</select>
			<div>
				<br>
			</div>
			<textarea name="event_details" id="event_details" rows="5" placeholder="EVENT DETAILS"></textarea>
			<div>
				<br>
			</div>
			<textarea name="organization_details" id="organization_details" rows="5" placeholder="ORGANIZATION DETAILS"></textarea>
			<div>
				<br>
			</div>
			<label>
				<input type="checkbox" name="social_share" id="social_share" placeholder="SOCIAL SHARE" value="1" />
				Allows Link to Facebook, Twitter and Instagram
			</label>
			<div>
				<br>
			</div>
			Create Tickets :
			<label>
				<input type="radio" name="ticket_type" id="ticket_type" class="ticket_type" placeholder="TICKET TYPE" value="0" checked /> None
				<input type="radio" name="ticket_type" id="ticket_type" class="ticket_type" placeholder="TICKET TYPE" value="1" /> Free
				<input type="radio" name="ticket_type" id="ticket_type" class="ticket_type" placeholder="TICKET TYPE" value="2" /> Paid
			</label>
			<div>
				<br>
			</div>
			<label>
				<input type="number" name="ticket_count" id="ticket_count" placeholder="TICKET COUNT" readonly /> 
				<input type="text" name="ticket_price" id="ticket_price" placeholder="TICKET PRICE" readonly /> 
			</label>
			<div>
				<br>
			</div>
			Privacy :
			<label>
				<input type="radio" name="event_privacy" id="event_privacy" class="event_privacy" value="0" placeholder="EVENT PRIVACY" checked /> Public
				<input type="radio" name="event_privacy" id="event_privacy" class="event_privacy" value="1" placeholder="EVENT PRIVACY" /> Private
			</label>
			<div>
				<br>
			</div>
			<input type="text" name="visible_to" id="visible_to" placeholder="SEND TO EMAILS" readonly />
			<div>
				<br>
			</div>
			Upload Event Image : 
			<input type="file" name="event_image" id="event_image" placeholder="EVENT IMAGE" />
			<div>
				<br>
			</div>
			<input type="hidden" name="_token" value="BuqTOq4oD63EyBst25h5bf5hFSW7IA7XB3Gql73k" />
			<button type="button" onclick="create()">Submit</button>
		</form>
	</body>
</html>
<script>

	$('input.ticket_type').change( function() {
		if( $(this).val() == 0 ) {
			$('input#ticket_count').attr('readonly', 'readonly');
			$('input#ticket_price').attr('readonly', 'readonly');
			$('input#ticket_count').val('');
			$('input#ticket_price').val('');
		}
		else if( $(this).val() == 1 ) {
			$('input#ticket_count').focus();
			$('input#ticket_count').removeAttr('readonly');
			$('input#ticket_price').attr('readonly', 'readonly');
			$('input#ticket_price').val('');
		}
		else if( $(this).val() == 2 ) {
			$('input#ticket_count').focus();
			$('input#ticket_count').removeAttr('readonly');
			$('input#ticket_price').removeAttr('readonly');
		}
		else {
			$('input#ticket_count').attr('readonly', 'readonly');
			$('input#ticket_price').attr('readonly', 'readonly');
			$('input#ticket_count').val('');
			$('input#ticket_price').val('');
		}
	});
	
	$('input.event_privacy').change( function() {
		if( $(this).val() == 0 ) {
			$('input#visible_to').attr('readonly', 'readonly');
			$('input#visible_to').removeAttr('required');
			$('input#visible_to').val('');
		}
		else if( $(this).val() == 1 ) {
			$('input#visible_to').focus();
			$('input#visible_to').removeAttr('readonly');
			$('input#visible_to').attr('required', 'required');
		}
		else {
			$('input#visible_to').attr('readonly', 'readonly');
			$('input#visible_to').removeAttr('required');
			$('input#visible_to').val('');
		}
	});
	
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/create/event/load',
			type: 'GET',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'language_code' : $('#language_code').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
					$('input#api_key').val(data.apikey);
				}
			}
		});
	}
	
	function generate(value) {
		
		if( value ) {
			$.ajax({
				url: 'http://www.howlik.com/api/generate/city',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('#token').val()
				},
				dataType:'json',
				data: { 'apikey' : $('#api_key').val(), 'country_code' : value },
				success: function(data) {
					if(data) {
						console.log(data);
						$('#output').html(JSON.stringify(data.status));
					}
				}
			});
		}
	}
	
	function create() {
		
		var post = {
					"apikey": "940281517988237",
					"city_code": "6988657",
					"country_code": "OM",
					"end_date": "28-2-2018",
					"event_details": "sjs",
					"event_image": "IMG_20180205_142432.jpg",
					"event_privacy": "Private Page",
					"event_title": "hejs",
					"event_type": "Conferences",
					"latitude": "76.30791796874999",
					"longitude": "10.003837499999998",
					"organization_details": "suei",
					"social_share": "Allow",
					"start_date": "23-2-2018",
					"ticket_count": "",
					"ticket_price": "",
					"ticket_type": "Paid Ticket",
					"visible_to": ["shs", "hehs", "hebs", "hehd", "dhs", "gss"]
					};
		
		if( post ) {
			$.ajax({
				url: 'http://www.howlik.com/api/create/event',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('#token').val()
				},
				dataType:'json',
				data: { 'data' : value },
				success: function(data) {
					if(data) {
						console.log(data);
						$('#output').html(JSON.stringify(data.status));
					}
				}
			});
		}
	}
	
</script>