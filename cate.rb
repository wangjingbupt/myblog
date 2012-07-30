#!/usr/bin/ruby -w
require 'find' 
result=[]
#Find.find('/Users/wangjingbupt/Downloads') do |path| 
path ="/Users/wangjingbupt/Documents/"
Dir.foreach(path) {|x| result<<x unless (FileTest.directory?(x) || x =~/\/\./ )}
r={	
	'soft'=>/\.dmg$|\.ipa|\.mpkg/i,
	'doc'=>/\.rtf|\.pages|\.txt|\.doc|\.docx|\.xls|\.xlsx|\.ppt|\.pptx|\.pdf/i,
	'pic'=>/\.bmp|\.jpg|\.png/i,
	'music'=>/\.mp3|\.amr|\.m4r/i,
	'packet'=>/\.zip|\.gz|\.rar|\.tar/i
}
res ={'soft'=>[],'doc'=>[],'pic'=>[],'music'=>[],'packet'=>[]}
result.each {|x| r.each {|key,reg| res[key].push(x) if x=~reg}}
r.each do |key,value|
	dirName = path+key+"/"
	oldDir = path
	Dir.mkdir(dirName) unless File.exists?(dirName)
	res[key].each{|v| File.rename(oldDir+v,dirName+v) }
end
