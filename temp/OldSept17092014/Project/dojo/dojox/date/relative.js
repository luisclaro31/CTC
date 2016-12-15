/*
	Copyright (c) 2004-2010, The Dojo Foundation All Rights Reserved.
	Available via Academic Free License >= 2.1 OR the modified BSD license.
	see: http://dojotoolkit.org/license for details
*/


if(!dojo._hasResource["dojox.date.relative"]){ //_hasResource checks added by build. Do not use _hasResource directly in your code.
dojo._hasResource["dojox.date.relative"] = true;
dojo.provide("dojox.date.relative");

dojo.require("dojo.date");
dojo.require("dojo.date.locale");

(function(d){
/*=====
	dojox.date.relative.__FormatOptions = function(){
	//	locale: String
	//		override the locale used to determine formatting rules
	//	relativeDate: Date
	//		Date to calculate relation to (defaults to new Date())
	//	weekCheck: boolean
	//		Whether or not to display the day of week (defaults true)
		this.locale = locale;
		this.relativeDate = relativeDate;
		this.weekCheck = weekCheck;
	}
=====*/

var DAY = 1000*60*60*24;
var SIX_DAYS = 6 * DAY;
var del = d.delegate;
var ddl = d.date.locale;
var ggb = ddl._getGregorianBundle;
var fmt = ddl.format;

function _clearTime(date){
	date = dojo.clone(date);
	date.setHours(0);
	date.setMinutes(0);
	date.setSeconds(0);
	date.setMilliseconds(0);
	return date;
}

dojox.date.relative.format = function(/*Date*/dateObject, /*dojox.date.relative.__FormatOptions?*/options){
	// summary:
	//		Format a Date object as a String, using locale-specific settings,
	//		relative to the current date or some other date.
	//
	// description:
	//		Create a string from a Date object using the most significant information
	//		and a known localized pattern.  This method formats both the date and
	//		time from dateObject.  Formatting patterns are chosen appropriate to
	//		the locale.
	//
	//		If the day portion of the date falls within the current date (or the
	//		relativeDate option, if present), then the time will be all that
	//		is displayed
	//
	//		If the day portion of the date falls within the past week (or the
	//		week preceeding relativeDate, if present), then the display will show
	//		day of week and time.  This functionality can be turned off by setting
	//		weekCheck to false.
	//
	//		If the year portion of the date falls within the current year (or the
	//		year portion of relativeDate, if present), then the display will show
	//		month and day.
	//
	//		Otherwise, this function is equivalent to calling dojo.date.format with
	//		formatLength of "medium"
	//
	// dateObject:
	//		the date and time to be formatted.
	
	options = options || {};
	
	var today = _clearTime(options.relativeDate || new Date());
	var diff = today.getTime() - _clearTime(dateObject).getTime();
	var fmtOpts = {locale: options.locale};
	
	if(diff === 0){
		// today: 9:32 AM
		return fmt(dateObject, del(fmtOpts, {selector: "time"}));
	}else if(diff <= SIX_DAYS && diff > 0 && options.weekCheck !== false){
		// within the last week: Mon 9:32 am
		return fmt(dateObject, del(fmtOpts, {selector: "date", datePattern: "EEE"})) + 
				" " +
				fmt(dateObject, del(fmtOpts, {selector: "time", formatLength: "short"}));
	}else if(dateObject.getFullYear() == today.getFullYear()){
		// this year: Nov 1
		var bundle = ggb(dojo.i18n.normalizeLocale(options.locale));
		return fmt(dateObject, del(fmtOpts, {
			selector: "date",
			datePattern: bundle["dateFormatItem-MMMd"]
		}));
	}else{
		// default: Jun 1, 2010
		return fmt(dateObject, del(fmtOpts, {
			selector: "date",
			formatLength: "medium",
			locale: options.locale
		}));
	}
};
})(dojo);

}
