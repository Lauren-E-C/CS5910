#!/bin/sh

sleep 1200

doit() {
echo curling: $1 $2
	while true
	do if curl -s -d 'term_in='$1'&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_subj='$2'&sel_crse=&sel_title=&sel_from_cred=&sel_to_cred=&sel_camp=%25&sel_levl=%25&sel_ptrm=%25&sel_instr=%25&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a' https://web-banner.oswego.edu/pls/prod/bwckschd.p_get_crse_unsec -o course_data/course_${2}_${1}_data.html
	then break
	fi
	echo recurling: $1 $2
	done
echo done: $1 $2
}



for dept in ACC ADO ASL ANT ARA ART AST BIO BHI BRC BLW CTE CHE CED CHI CSS COG CAS CMA COM CSC CPS CRW CRJ DNC DASA ECH ECO EDU EAD ECE ENG FIN FRE GWS GST GCH GEG GEO GER GLS HSC HIS HON HCI HDV HRM ISC INT ITA JPN JLM LIN LIT MGT MKT MBA MAT MAX MET MSC MUS NAS PCS PHL PED PHY POL PSY PRL RMI SSHS SOC SPA SPE SUS TSL TEL TED THT ZOO
	do for semester in 202101 202012 202010 202009 202002 202001 201912 201910 201909 201902 201901 201812 201810 201809 201802 201801 201712 201710 201709 201702 201701 201612 201610 201609 201602 201601
		do doit $semester $dept &
	done
	echo waiting...
	wait
	echo resuming.
done
