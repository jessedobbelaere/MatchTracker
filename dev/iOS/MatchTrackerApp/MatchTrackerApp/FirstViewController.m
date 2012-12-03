//
//  FirstViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 3/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import "FirstViewController.h"
#import <RestKit/RestKit.h>
#import "Article.h"

@interface FirstViewController ()

@end

@implementation FirstViewController
@synthesize manager;

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    // Set manager
    NSURL *url = [NSURL URLWithString:@"http://localhost"];
    manager = [RKObjectManager managerWithBaseURL:url];

    [manager getObjectsAtPath:@"/apitest.php" parameters:nil success:^(RKObjectRequestOperation *operation, RKMappingResult *mappingResult)
    {
        NSLog(@"It Worked: %@", [mappingResult array]);
        // Or if you're only expecting a single object:
        NSLog(@"It Worked: %@", [mappingResult firstObject]);
    } failure:^(RKObjectRequestOperation *operation, NSError *error) {
        NSLog(@"It Failed: %@", error);
    }];
    
    /*
    RKObjectMapping *mapping = [RKObjectMapping mappingForClass:[Article class]];
    [mapping addAttributeMappingsFromArray:@[@"title", @"author", @"body"]];
    NSIndexSet *statusCodes = RKStatusCodeIndexSetForClass(RKStatusCodeClassSuccessful); // Anything in 2xx
    RKResponseDescriptor *responseDescriptor = [RKResponseDescriptor responseDescriptorWithMapping:mapping pathPattern:@"apitest.php" keyPath:@"article" statusCodes:statusCodes];
    
    NSURLRequest *request = [NSURLRequest requestWithURL:[NSURL URLWithString:@"http://localhost/"]];
    RKObjectRequestOperation *operation = [[RKObjectRequestOperation alloc] initWithRequest:request responseDescriptors:@[responseDescriptor]];
    [operation setCompletionBlockWithSuccess:^(RKObjectRequestOperation *operation, RKMappingResult *result) {
        Article *article = [result firstObject];
        NSLog(@"Mapped the article: %@", article);
    } failure:^(RKObjectRequestOperation *operation, NSError *error) {
        NSLog(@"Failed with error: %@", [error localizedDescription]);
    }];
     
     */
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
