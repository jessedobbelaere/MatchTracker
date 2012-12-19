//
//  Article.h
//  MatchTrackerApp
//
//  Created by Jesse on 6/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface Article : NSObject
@property (nonatomic, retain) NSString* title;
@property (nonatomic, retain) NSString* body;
@property (nonatomic, retain) NSString* author;
@property (nonatomic, retain) NSDate*   publicationDate;
@end
